@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-gray-500 mt-1">Track your postgraduate presentation application status.</p>
        </div>

        @if (auth()->user()->role == 'student')
            <div class="mt-4 md:mt-0">
                <span
                    class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 text-sm font-bold px-4 py-2 rounded-full border border-indigo-100 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Student Account
                </span>
            </div>
        @endif
    </div>

    @if (auth()->user()->role == 'student')

        @if (!$submission)
            <div class="max-w-2xl mx-auto mt-10">
                <div
                    class="bg-white p-10 rounded-2xl shadow-sm text-center border border-gray-100 hover:shadow-md transition duration-300">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 text-blue-600 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">No Active Presentation Request</h2>
                    <p class="text-gray-500 mb-8 mt-3 max-w-md mx-auto">You are not currently queued for any presentation.
                        Submit your proposal or pre-viva request to get started.</p>

                    <a href="{{ route('student.submission.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Start New Submission
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div
                    class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $submission->title }}</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Type:</span>
                            <span
                                class="text-sm font-semibold text-gray-700 bg-white border border-gray-200 px-2 py-0.5 rounded shadow-sm">
                                {{ ucfirst($submission->presentation_type) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        @if ($submission->manager_status == 'finalized')
                            <span
                                class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Scheduled
                            </span>
                        @elseif($submission->supervisor_status == 'rejected')
                            <span
                                class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm">
                                Returned
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm">
                                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> In Progress
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-8">
                    <div class="mb-10">
                        <div class="relative flex items-center justify-between w-full max-w-4xl mx-auto">
                            <div
                                class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-100 rounded-full -z-10">
                            </div>

                            <div class="flex flex-col items-center bg-white px-4">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-md transition-all duration-500 bg-green-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-green-600 mt-3">Submitted</p>
                            </div>

                            <div
                                class="flex-1 h-1 mx-2 {{ $submission->supervisor_status == 'approved' ? 'bg-green-500' : 'bg-gray-100' }} rounded-full transition-all duration-500">
                            </div>

                            <div class="flex flex-col items-center bg-white px-4">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-md transition-all duration-500
                                    {{ $submission->supervisor_status == 'approved' ? 'bg-green-500 text-white' : ($submission->supervisor_status == 'rejected' ? 'bg-red-500 text-white' : 'bg-white border-2 border-gray-200 text-gray-400') }}">
                                    @if ($submission->supervisor_status == 'approved')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @elseif($submission->supervisor_status == 'rejected')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    @else
                                        2
                                    @endif
                                </div>
                                <p
                                    class="text-sm font-bold mt-3 {{ $submission->supervisor_status == 'approved' ? 'text-green-600' : 'text-gray-500' }}">
                                    Supervisor Review</p>
                            </div>

                            <div
                                class="flex-1 h-1 mx-2 {{ $submission->manager_status == 'finalized' ? 'bg-green-500' : 'bg-gray-100' }} rounded-full transition-all duration-500">
                            </div>

                            <div class="flex flex-col items-center bg-white px-4">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-md transition-all duration-500
                                    {{ $submission->manager_status == 'finalized' ? 'bg-green-500 text-white' : 'bg-white border-2 border-gray-200 text-gray-400' }}">
                                    @if ($submission->manager_status == 'finalized')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        3
                                    @endif
                                </div>
                                <p
                                    class="text-sm font-bold mt-3 {{ $submission->manager_status == 'finalized' ? 'text-green-600' : 'text-gray-500' }}">
                                    Scheduling</p>
                            </div>
                        </div>
                    </div>

                    @if ($submission->schedule)
                        <div
                            class="bg-green-50 border border-green-200 rounded-xl p-6 flex flex-col md:flex-row items-start gap-5">
                            <div class="p-3 bg-white rounded-lg shadow-sm text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-green-900">Presentation Confirmed!</h3>
                                <p class="text-green-700 text-sm mt-1">Your session has been locked in. Please arrive at the
                                    venue 15 minutes early.</p>

                                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-white/60 p-3 rounded border border-green-100">
                                        <p class="text-xs font-bold text-green-800 uppercase">Date</p>
                                        <p class="font-semibold text-green-900">
                                            {{ \Carbon\Carbon::parse($submission->schedule->presentation_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="bg-white/60 p-3 rounded border border-green-100">
                                        <p class="text-xs font-bold text-green-800 uppercase">Time</p>
                                        <p class="font-semibold text-green-900">
                                            {{ \Carbon\Carbon::parse($submission->schedule->start_time)->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="bg-white/60 p-3 rounded border border-green-100">
                                        <p class="text-xs font-bold text-green-800 uppercase">Venue</p>
                                        <p class="font-semibold text-green-900">{{ $submission->schedule->venue }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($submission->supervisor_status == 'rejected')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6 flex items-start gap-4">
                            <div class="text-red-500 bg-white p-2 rounded-full shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-900">Submission Returned</h3>
                                <p class="text-red-800 text-sm mt-1">Your supervisor has returned your application. Please
                                    contact them for feedback and required revisions.</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-8 text-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-4"></div>
                            <h3 class="text-lg font-bold text-blue-900">Processing...</h3>
                            <p class="text-blue-700 text-sm mt-1">Your application is currently being reviewed. We will
                                notify you once the status changes.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    @endif

    @if (auth()->user()->role == 'manager')
        @include('manager.dashboard_partial')
    @endif

@endsection
