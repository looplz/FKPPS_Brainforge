<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import Mail
use App\Mail\AccountApproved;        // Import Mail Class

class UserProfileController extends Controller
{
    // 1. Register Logic
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:student,supervisor',
            'phone' => 'required'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Registration submitted. Wait for Manager approval.');
    }

    // 2. Show Pending Users (Manager)
    public function pendingUsers() {
        $users = User::where('status', 'pending')->get();
        return view('manager.users.pending', compact('users'));
    }

    // 3. Approve User (Manager) - WITH EMAIL
    public function approveUser($id) {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        // Send Email Notification
        Mail::to($user->email)->send(new AccountApproved($user));

        return back()->with('success', 'User approved and notified via email.');
    }

    // 4. Update Profile (Legacy/Simple) - You can remove this if using the 'update' method below
    public function updateProfile(Request $request) {
        $user = auth()->user();
        $user->update($request->only(['name', 'phone', 'password']));
        return back()->with('success', 'Profile updated.');
    }

    // 5. Generate Report
    public function generateUserReport() {
        $users = User::all();
        return view('manager.reports.users', compact('users'));
    }

    // 6. Show Login Form
    public function showLogin() {
        return view('auth.login');
    }

    // 7. Show Register Form
    public function showRegister() {
        return view('auth.register');
    }

    // 8. Handle Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Check Active Status
            if (auth()->user()->status === 'pending') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is still pending approval by the Manager.']);
            }

            return redirect()->intended('dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 9. Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // 10. Show Edit Profile Form
    public function edit() {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    // 11. Update Profile (Robust Validation)
    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}