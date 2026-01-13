<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Submission;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create($submission_id) {
        $submission = Submission::findOrFail($submission_id);
        return view('manager.schedule.create', compact('submission'));
    }

    public function store(Request $request) {
        $request->validate([
            'submission_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'venue' => 'required'
        ]);

        $submission = Submission::with(['supervisor', 'student'])->findOrFail($request->submission_id);

        // --- CONFLICT CHECKING LOGIC ---

        // 1. Venue Conflict
        $venueConflict = Schedule::where('presentation_date', $request->date)
            ->where('venue', $request->venue)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($venueConflict) {
            return back()->withErrors(['venue' => 'Venue is booked at this time.']);
        }

        // 2. Person Conflict (Supervisor/Examiners)
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
            return back()->withErrors(['time' => 'Supervisor or Examiner has a clash.']);
        }

        // --- END CONFLICT CHECK ---

        Schedule::create([
            'submission_id' => $request->submission_id,
            'presentation_date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'venue' => $request->venue,
            'created_by' => auth()->id()
        ]);

        // FIX IS HERE: Changed 'manager.dashboard' to 'dashboard'
        return redirect()->route('dashboard')->with('success', 'Schedule Confirmed.');
    }
}