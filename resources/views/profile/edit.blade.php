@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow border-t-4 border-blue-900">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">My Profile</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-semibold mb-1">Role</label>
                <input type="text" value="{{ ucfirst(auth()->user()->role) }}" readonly
                    class="w-full bg-gray-100 border border-gray-300 text-gray-500 p-2 rounded cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="w-full border p-2 rounded focus:ring-blue-900 focus:border-blue-900" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                    class="w-full border p-2 rounded focus:ring-blue-900 focus:border-blue-900" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                    class="w-full border p-2 rounded focus:ring-blue-900 focus:border-blue-900" required>
            </div>

            <hr class="my-6 border-gray-200">
            <h3 class="text-lg font-bold mb-4 text-gray-700">Change Password <span
                    class="text-sm font-normal text-gray-500">(Leave blank to keep current)</span></h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">New Password</label>
                    <input type="password" name="password"
                        class="w-full border p-2 rounded focus:ring-blue-900 focus:border-blue-900">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border p-2 rounded focus:ring-blue-900 focus:border-blue-900">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
