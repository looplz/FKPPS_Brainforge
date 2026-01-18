<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSubmission;

class SubmissionController extends Controller
{
    // --- MODULE 2: STUDENT SUBMISSION ---

    // 1. Student: Submit Document
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'document' => 'required|mimes:pdf,doc,docx|max:10000',
            'supervisor_id' => 'required|exists:users,id',
            'type' => 'required'
        ]);

        $path = $request->file('document')->store('submissions');

        // FIX IS HERE: Add "$submission =" before Submission::create
        $submission = Submission::create([
            'student_id' => Auth::id(),
            'title' => $request->title,
            'document_path' => $path,
            'presentation_type' => $request->type,
            'supervisor_id' => $request->supervisor_id
        ]);

        // FETCH SUPERVISOR
        $supervisor = User::find($request->supervisor_id);

        // SEND EMAIL
        if ($supervisor) {
            // Now $submission exists, so this works!
            Mail::to($supervisor->email)->send(new NewSubmission($submission));
        }

        return redirect()->route('dashboard')->with('success', 'Presentation requested.');
    }

    // --- MODULE 2: SUPERVISOR APPROVAL ---

    // 2. Supervisor: Approve & Nominate
    public function supervisorAction(Request $request, $id) {
        $submission = Submission::findOrFail($id);

        if($request->action == 'approve') {
            $request->validate([
                'examiner_1' => 'required|exists:users,id',
                'examiner_2' => 'required|exists:users,id',
            ]);

            $submission->update([
                'supervisor_status' => 'approved',
                'examiner_1_id' => $request->examiner_1,
                'examiner_2_id' => $request->examiner_2
            ]);
        } else {
            $submission->update(['supervisor_status' => 'rejected']);
        }

        return back()->with('success', 'Submission status updated.');
    }

    // --- MODULE 3: MANAGER ACTIONS ---

    // 3. Manager: View All Submissions (THIS WAS MISSING)
    public function index() {
        // Show only submissions that Supervisors have already approved
        $submissions = Submission::where('supervisor_status', 'approved')
                                 ->with(['student', 'supervisor']) // Eager load for performance
                                 ->get();

        return view('manager.submission.index', compact('submissions'));
    }

    // 4. Manager: Finalize Submission
    public function managerFinalize($id) {
        $submission = Submission::findOrFail($id);
        $submission->update(['manager_status' => 'finalized']);

        return back()->with('success', 'Submission finalized. Ready for scheduling.');
    }

    // 5. View Document Function
    public function viewDocument($id)
    {
        $submission = Submission::findOrFail($id);

        // Check if file exists in the storage
        // Note: This assumes you used the default storage method
        if (!Storage::exists($submission->document_path)) {
            abort(404, 'File not found.');
        }

        // Return the file to the browser
        return response()->file(storage_path('app/' . $submission->document_path));
    }
}