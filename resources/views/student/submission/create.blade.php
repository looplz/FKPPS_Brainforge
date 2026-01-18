@extends('layouts.app')

@section('content')
    @php
        $supervisors = \App\Models\User::where('role', 'supervisor')->where('status', 'active')->get();
    @endphp

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center text-gray-500 hover:text-blue-900 mb-6 transition group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-8 py-8 text-white">
                <h1 class="text-2xl font-bold tracking-tight">New Presentation Request</h1>
                <p class="text-blue-100 mt-2 text-sm">Please fill in the details below to submit your proposal or pre-viva
                    application for review.</p>
            </div>

            <form action="{{ url('/submission') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Project Title</label>
                    <input type="text" name="title"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition p-3 text-gray-800 placeholder-gray-400"
                        placeholder="Enter the full title of your research..." required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Presentation Stage</label>
                        <div class="relative">
                            <select name="type"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm appearance-none p-3 bg-white"
                                required>
                                <option value="proposal">Proposal Defense</option>
                                <option value="pre-viva">Pre-Viva</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700">Select Supervisor</label>
                        <div class="relative">
                            <select name="supervisor_id"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm appearance-none p-3 bg-white"
                                required>
                                <option value="">-- Choose your supervisor --</option>
                                @foreach ($supervisors as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">Upload Thesis/Slides</label>

                    <div class="relative group">
                        <label for="file-upload"
                            class="flex justify-center px-6 pt-10 pb-10 border-2 border-gray-300 border-dashed rounded-xl hover:bg-blue-50 hover:border-blue-300 transition cursor-pointer">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <div class="text-sm text-gray-600">
                                    <span class="font-medium text-blue-600 hover:text-blue-500">Click to upload</span>
                                    <span class="pl-1">or drag and drop</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Supported: PDF, DOC, DOCX (Max 10MB)
                                </p>
                                <p id="file-name" class="text-sm font-bold text-blue-800 mt-2 h-5"></p>
                            </div>
                            <input id="file-upload" name="document" type="file" class="sr-only" accept=".pdf,.doc,.docx"
                                required
                                onchange="document.getElementById('file-name').innerText = 'Selected: ' + this.files[0].name">
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 rounded-lg bg-blue-900 text-white font-bold hover:bg-blue-800 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
