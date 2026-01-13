<div class="space-y-8 mt-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ $pendingUsersCount > 0 ? 'border-yellow-500' : 'border-green-500' }} flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Registrations</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $pendingUsersCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Require Validation</p>
            </div>
            <div
                class="p-3 rounded-full {{ $pendingUsersCount > 0 ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ $pendingSubmissionsCount > 0 ? 'border-blue-600' : 'border-gray-300' }} flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ready for Scheduling</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $pendingSubmissionsCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Approved by Supervisors</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Upcoming Sessions</p>
                <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $upcomingSchedules->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Next scheduled events</p>
            </div>
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                <span class="w-2 h-6 bg-blue-900 rounded-full"></span> System Modules
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('manager.users') }}"
                    class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-center gap-4 mb-3">
                        <div
                            class="p-3 bg-blue-50 text-blue-700 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800">Validate Users</h4>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Review pending registration requests from new supervisors and
                        postgraduate students.</p>
                    <span class="text-blue-600 text-sm font-semibold group-hover:underline">Process
                        {{ $pendingUsersCount }} Requests &rarr;</span>
                </a>

                <a href="{{ route('manager.submissions') }}"
                    class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition border border-gray-100">
                    <div class="flex items-center gap-4 mb-3">
                        <div
                            class="p-3 bg-green-50 text-green-700 rounded-lg group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800">Manage Submissions</h4>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">Finalize approved proposals and coordinate presentation
                        schedules with venues.</p>
                    <span class="text-green-600 text-sm font-semibold group-hover:underline">Action
                        {{ $pendingSubmissionsCount }} Items &rarr;</span>
                </a>
            </div>

            <div
                class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg text-white p-6 flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold">System Reports & Analytics</h3>
                    <p class="text-gray-400 text-sm mt-1">Generate comprehensive reports for users and presentation
                        sessions.</p>
                </div>
                <div class="flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('manager.reports.users') }}"
                        class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded text-sm transition border border-white/20">View
                        Users</a>
                    <button onclick="window.print()"
                        class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded text-sm transition shadow">Print
                        Dashboard</button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2 mb-6">
                <span class="w-2 h-6 bg-purple-900 rounded-full"></span> Upcoming Sessions
            </h3>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @forelse($upcomingSchedules as $schedule)
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex flex-col items-center bg-purple-50 text-purple-700 rounded p-2 min-w-[50px]">
                                <span
                                    class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($schedule->presentation_date)->format('M') }}</span>
                                <span
                                    class="text-lg font-extrabold">{{ \Carbon\Carbon::parse($schedule->presentation_date)->format('d') }}</span>
                            </div>

                            <div>
                                <p class="text-sm font-bold text-gray-800 line-clamp-1">
                                    {{ $schedule->submission->student->name }}</p>
                                <p class="text-xs text-gray-500 mb-1">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                    {{ $schedule->venue }}</p>
                                <span
                                    class="inline-block bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full uppercase font-bold">
                                    {{ $schedule->submission->presentation_type }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">No upcoming sessions scheduled.</p>
                    </div>
                @endforelse

                @if ($upcomingSchedules->count() > 0)
                    <div class="p-3 bg-gray-50 text-center">
                        <a href="#" class="text-xs font-bold text-purple-700 hover:underline">View Full
                            Calendar</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
