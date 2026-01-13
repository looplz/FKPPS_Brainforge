<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ScheduleController;
use App\Models\Submission;
use App\Models\User;
use App\Models\Schedule;

Route::get('/', function () { return view('welcome'); });

// --- GUEST ROUTES (Login & Register) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserProfileController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserProfileController::class, 'login'])->name('login.post');

    Route::get('/register', [UserProfileController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserProfileController::class, 'register'])->name('register.post');
});

// --- AUTHENTICATED LOGOUT ---
Route::post('/logout', [UserProfileController::class, 'logout'])->middleware('auth')->name('logout');

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // 1. GLOBAL: View Document (Secure)
    Route::get('/submission/{id}/document', [SubmissionController::class, 'viewDocument'])
        ->name('submission.document');

    // 2. GLOBAL: Profile Management
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile']);

    // 3. SMART DASHBOARD (Redirects based on Role)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // A. LOGIC FOR SUPERVISOR
        if ($user->role == 'supervisor') {
            $submissions = Submission::where('supervisor_id', $user->id)
                                     ->where('supervisor_status', 'pending')
                                     ->get();
            $examiners = User::where('role', 'supervisor')
                             ->where('id', '!=', $user->id)
                             ->get();
            return view('supervisor.dashboard', compact('submissions', 'examiners'));
        }

        // B. LOGIC FOR STUDENT
        if ($user->role == 'student') {
            $submission = Submission::with('schedule')
                                    ->where('student_id', $user->id)
                                    ->latest()
                                    ->first();
            return view('dashboard', compact('submission'));
        }

        // C. LOGIC FOR MANAGER
        if ($user->role == 'manager') {
            // Stats 1: Pending Users
            $pendingUsersCount = User::where('status', 'pending')->count();

            // Stats 2: Pending Submissions
            $pendingSubmissionsCount = Submission::where('supervisor_status', 'approved')
                                                 ->where('manager_status', 'pending')
                                                 ->count();

            // Stats 3: Upcoming Presentations
            $upcomingSchedules = Schedule::with(['submission.student'])
                                    ->where('presentation_date', '>=', now())
                                    ->orderBy('presentation_date', 'asc')
                                    ->orderBy('start_time', 'asc')
                                    ->take(3)
                                    ->get();

            return view('dashboard', compact('pendingUsersCount', 'pendingSubmissionsCount', 'upcomingSchedules'));
        }

        // Fallback (e.g., if no role or pending)
        return view('dashboard');

    })->name('dashboard');


    // --- ROLE SPECIFIC ROUTES ---

    // Student Routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/submission/create', function() {
            return view('student.submission.create');
        })->name('student.submission.create');

        Route::post('/submission', [SubmissionController::class, 'store']);
    });

    // Supervisor Routes
    Route::middleware(['role:supervisor'])->group(function () {
        Route::post('/submission/{id}/approve', [SubmissionController::class, 'supervisorAction']);
    });

    // Manager Routes
    Route::middleware(['role:manager'])->group(function () {

        // Module 1: User Management
        Route::get('/manager/users/pending', [UserProfileController::class, 'pendingUsers'])
            ->name('manager.users');

        Route::post('/manager/users/{id}/approve', [UserProfileController::class, 'approveUser'])
            ->name('manager.users.approve');

        Route::get('/manager/reports/users', [UserProfileController::class, 'generateUserReport'])
            ->name('manager.reports.users');

        // Module 2 & 3: Submissions & Scheduling
        Route::get('/manager/submissions', [SubmissionController::class, 'index'])
            ->name('manager.submissions');

        Route::post('/manager/submission/{id}/finalize', [SubmissionController::class, 'managerFinalize'])
            ->name('manager.submission.finalize');

        Route::get('/manager/schedule/{submission_id}', [ScheduleController::class, 'create'])
            ->name('manager.schedule.create');

        Route::post('/manager/schedule', [ScheduleController::class, 'store'])
            ->name('manager.schedule.store');
    });
});