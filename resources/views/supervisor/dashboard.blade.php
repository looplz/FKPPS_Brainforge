@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-gray-500 mt-1">Manage your postgraduate student supervision requests.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span
                class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 text-sm font-bold px-4 py-2 rounded-full shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Supervisor Account
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-700 flex items-center gap-2">
                    <span class="w-2 h-6 bg-yellow-500 rounded-full"></span>
                    Pending Approvals
                    <span
                        class="bg-gray-200 text-gray-700 text-xs py-0.5 px-2 rounded-full ml-2">{{ $submissions->count() }}</span>
                </h2>
            </div>

            <div class="space-y-6">
                @forelse($submissions as $sub)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-300">

                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $sub->title }}</h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        {{ $sub->student->name }}
                                    </span>
                                    <span class="text-gray-300">|</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                        {{ ucfirst($sub->presentation_type) }}
                                    </span>
                                </div>
                            </div>
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                Action Required
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="mb-6">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">1. Review
                                    Submission</p>
                                <a href="{{ route('submission.document', $sub->id) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-blue-600 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition font-medium text-sm border border-blue-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Download Proposal PDF
                                </a>
                            </div>

                            <hr class="border-gray-100 my-6">

                            <form action="{{ url('/submission/' . $sub->id . '/approve') }}" method="POST">
                                @csrf

                                <div class="mb-6">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">2. Nominate
                                        Examiners</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Examiner 1</label>
                                            <select name="examiner_1"
                                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                                required>
                                                <option value="">-- Select Lecturer --</option>
                                                @foreach ($examiners as $ex)
                                                    <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Examiner 2</label>
                                            <select name="examiner_2"
                                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                                required>
                                                <option value="">-- Select Lecturer --</option>
                                                @foreach ($examiners as $ex)
                                                    <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 pt-2">
                                    <button name="action" value="approve"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-sm transition flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve & Nominate
                                    </button>

                                    <button name="action" value="reject"
                                        class="bg-white border border-red-200 text-red-600 hover:bg-red-50 font-semibold py-2.5 px-6 rounded-lg transition flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">All Caught Up!</h3>
                        <p class="text-gray-500 mt-2">You have no pending student requests at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
