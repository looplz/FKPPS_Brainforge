@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Register Account</h2>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Full Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email Address</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Phone Number</label>
                <input type="text" name="phone" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Role</label>
                <select name="role" class="w-full border p-2 rounded">
                    <option value="student">Postgraduate Student</option>
                    <option value="supervisor">Supervisor</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white p-2 rounded hover:bg-blue-800">
                Register
            </button>
        </form>
    </div>
@endsection
