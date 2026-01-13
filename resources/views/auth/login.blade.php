@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="w-full max-w-md bg-white p-8 rounded shadow-lg border-t-4 border-blue-900">

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">FKPPS Login</h2>
            <p class="text-center text-gray-500 mb-6 text-sm">FK Postgraduate Presentation System</p>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                    <p class="font-bold">Login Failed</p>
                    <p>Please check your credentials.</p>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email"
                        class="w-full border-gray-300 border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                        placeholder="user@ump.edu.my" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border-gray-300 border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                        placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2 leading-tight">
                        <span class="text-sm">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-900 text-white font-bold py-2 px-4 rounded hover:bg-blue-800 transition duration-200 shadow-md">
                    Login to FKPPS
                </button>
            </form>

            <div class="mt-6 text-center border-t pt-4">
                <p class="text-gray-600 text-sm">
                    New User?
                    <a href="{{ route('register') }}" class="text-blue-900 font-bold hover:underline">Register Account</a>
                </p>
            </div>
        </div>
    </div>
@endsection
