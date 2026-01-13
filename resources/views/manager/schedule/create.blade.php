@extends('layouts.app')

@section('content')
    <div class="flex gap-6">
        <div class="w-1/3">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">Scheduling For:</h3>
                <p class="text-gray-800 font-semibold">{{ $submission->title }}</p>
                <p class="text-sm text-gray-600 mt-2">Student: {{ $submission->student->name }}</p>
                <p class="text-sm text-gray-600">Supervisor: {{ $submission->supervisor->name }}</p>
                <p class="text-sm text-gray-600">Examiner 1: {{ $submission->examiner_1_id }}</p>
                <p class="text-sm text-gray-600">Examiner 2: {{ $submission->examiner_2_id }}</p>
            </div>
        </div>

        <div class="w-2/3">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Set Date & Venue</h2>

                <form action="{{ url('/manager/schedule') }}" method="POST">
                    @csrf
                    <input type="hidden" name="submission_id" value="{{ $submission->id }}">

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-semibold">Date</label>
                            <input type="date" name="date" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block font-semibold">Venue</label>
                            <select name="venue" class="w-full border p-2 rounded">
                                <option value="Meeting Room 1">Meeting Room 1</option>
                                <option value="Meeting Room 2">Meeting Room 2</option>
                                <option value="Auditorium">Auditorium</option>
                                <option value="Lab 3">Lab 3</option>
                            </select>
                            @error('venue')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block font-semibold">Start Time</label>
                            <input type="time" name="start_time" class="w-full border p-2 rounded" required>
                            @error('time')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold">End Time</label>
                            <input type="time" name="end_time" class="w-full border p-2 rounded" required>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 w-full">
                        Confirm Schedule & Notify
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
