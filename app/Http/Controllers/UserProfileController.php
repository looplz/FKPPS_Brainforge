<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
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

    public function pendingUsers() {
        $users = User::where('status', 'pending')->get();
        return view('manager.users.pending', compact('users'));
    }

    public function approveUser($id) {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return back()->with('success', 'User approved successfully.');
    }

    public function updateProfile(Request $request) {
        $user = auth()->user();
        $user->update($request->only(['name', 'phone', 'password']));
        return back()->with('success', 'Profile updated.');
    }

    public function generateUserReport() {
        $users = User::all();
        // Return view or PDF export logic
        return view('manager.reports.users', compact('users'));
    }

        // 1. Show the Login Form
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Handle the Login Logic
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Check if user status is active (Module 1 Requirement)
            if (auth()->user()->status === 'pending') {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is still pending approval by the Manager.']);
            }

            return redirect()->intended('dashboard')->with('success', 'Welcome back!');
        }

        // If auth fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

public function edit()
{
    return view('profile.edit', ['user' => auth()->user()]);
}

public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|unique:users,email,'.$user->id, // Ignore current user's email
        'password' => 'nullable|min:8|confirmed', // Optional, matches password_confirmation
    ]);

    // Update basic fields
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->email = $request->email;

    // Only update password if the user entered one
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}
}
