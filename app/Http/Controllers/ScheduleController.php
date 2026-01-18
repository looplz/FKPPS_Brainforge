<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Import Mail Facade
use App\Mail\PresentationScheduled;  // Import the Mailable

class ScheduleController extends Controller
{
    public function create($submission_id) {
        $submission = Submission::findOrFail($submission_id);
        return view('manager.schedule.create', compact('submission'));
    }

    public function store(Request $request) {
        // 1. Validate Input
        $request->validate([
            'submission_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'venue' => 'required'
        ]);

        $submission = Submission::with(['supervisor', 'student'])->findOrFail($request->submission_id);

        // --- CONFLICT CHECKING LOGIC (Module 3 Requirement) ---

        // 2. Check Venue Conflict
        // Ensure the room isn't double-booked at this time[cite: 92].
        $venueConflict = Schedule::where('presentation_date', $request->date)
            ->where('venue', $request->venue)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($venueConflict) {
            return back()->withErrors(['venue' => 'Venue is booked at this time.']);
        }

        // 3. Check Person Conflict (Supervisor/Examiners)
        // Ensure faculty members aren't in two places at once[cite: 92].
        $peopleInvolved = [
            $submission->supervisor_id,
            $submission->examiner_1_id,
            $submission->examiner_2_id
        ];

        $personConflict = Schedule::where('presentation_date', $request->date)
            ->whereHas('submission', function($q) use ($peopleInvolved) {
                $q->whereIn('supervisor_id', $peopleInvolved)
                  ->orWhereIn('examiner_1_id', $peopleInvolved)
                  ->orWhereIn('examiner_2_id', $peopleInvolved);
            })
            ->where(function($query) use ($request) {
                 $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                       ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($personConflict) {
            return back()->withErrors(['time' => 'Supervisor or Examiner has a clash with another session.']);
        }

        // --- CREATE SCHEDULE ---

        $schedule = Schedule::create([
            'submission_id' => $request->submission_id,
            'presentation_date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'venue' => $request->venue,
            'created_by' => auth()->id()
        ]);

        // Update Submission Status to 'finalized'
        $submission->manager_status = 'finalized';
        $submission->save();

        // --- EMAIL NOTIFICATIONS (Module 3 Requirement) ---
        // Notify Student, Supervisor, and Examiners.

        $recipients = [];

        // Add Student
        if ($submission->student) {
            $recipients[] = $submission->student->email;
        }

        // Add Supervisor
        if ($submission->supervisor) {
            $recipients[] = $submission->supervisor->email;
        }

        // Add Examiner 1
        if ($submission->examiner_1_id) {
            $ex1 = User::find($submission->examiner_1_id);
            if ($ex1) $recipients[] = $ex1->email;
        }

        // Add Examiner 2
        if ($submission->examiner_2_id) {
            $ex2 = User::find($submission->examiner_2_id);
            if ($ex2) $recipients[] = $ex2->email;
        }

        // Send the emails
        foreach ($recipients as $email) {
            Mail::to($email)->send(new PresentationScheduled($schedule));
        }

        return redirect()->route('dashboard')->with('success', 'Schedule Confirmed and Emails Sent.');
    }
}