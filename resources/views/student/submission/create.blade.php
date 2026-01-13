@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Request Presentation</h2>

        <form action="{{ url('/submission') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Project Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded" placeholder="Enter thesis title..."
                    required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Presentation Type</label>
                    <select name="type" class="w-full border p-2 rounded">
                        <option value="proposal">Proposal Defense</option>
                        <option value="pre-viva">Pre-Viva</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Select Supervisor</label>
                    <select name="supervisor_id" class="w-full border p-2 rounded">
                        @foreach (\App\Models\User::where('role', 'supervisor')->get() as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold">Upload Document (PDF)</label>
                <input type="file" name="document" class="w-full border p-2 rounded" accept=".pdf" required>
                <p class="text-xs text-gray-500 mt-1">Max size: 10MB</p>
            </div>

            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">
                Submit Request
            </button>
        </form>
    </div>
@endsection
