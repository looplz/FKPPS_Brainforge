@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">System User Report</h2>
            <button onclick="window.print()"
                class="bg-blue-900 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print Report
            </button>
        </div>

        <div class="bg-white p-6 rounded shadow border-t-4 border-blue-900">
            <div class="mb-4 border-b pb-4">
                <h3 class="text-lg font-bold uppercase">Faculty of Computing, UMPSA</h3>
                <p class="text-sm text-gray-600">FK Postgraduate Presentation System (FKPPS)</p>
                <p class="text-sm text-gray-600">Generated on: {{ now()->format('d M Y, h:i A') }}</p>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-300">
                        <th class="p-3 font-semibold text-gray-700">#</th>
                        <th class="p-3 font-semibold text-gray-700">Full Name</th>
                        <th class="p-3 font-semibold text-gray-700">Email</th>
                        <th class="p-3 font-semibold text-gray-700">Role</th>
                        <th class="p-3 font-semibold text-gray-700">Phone</th>
                        <th class="p-3 font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-3 font-medium">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 rounded text-xs font-bold uppercase
                            {{ $user->role == 'manager'
                                ? 'bg-purple-100 text-purple-800'
                                : ($user->role == 'supervisor'
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-gray-100 text-gray-800') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-3">{{ $user->phone ?? '-' }}</td>
                            <td class="p-3">
                                @if ($user->status == 'active')
                                    <span class="text-green-600 font-bold text-sm">Active</span>
                                @else
                                    <span class="text-yellow-600 font-bold text-sm">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">No users found in the database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-8 text-center text-xs text-gray-400">
                End of Report
            </div>
        </div>
    </div>
@endsection
