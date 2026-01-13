@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Manage Submissions</h2>

        <div class="bg-white p-6 rounded shadow border-t-4 border-blue-900">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 font-semibold text-gray-700">Project Title</th>
                        <th class="p-3 font-semibold text-gray-700">Student</th>
                        <th class="p-3 font-semibold text-gray-700">Supervisor</th>
                        <th class="p-3 font-semibold text-gray-700">Manager Status</th>
                        <th class="p-3 font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $sub)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3">
                                <span class="font-bold block">{{ $sub->title }}</span>
                                <span class="text-xs text-gray-500 uppercase">{{ $sub->presentation_type }}</span>
                            </td>
                            <td class="p-3">{{ $sub->student->name }}</td>
                            <td class="p-3 text-sm">{{ $sub->supervisor->name }}</td>

                            <td class="p-3">
                                @if ($sub->manager_status == 'finalized')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Finalized</span>
                                @else
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold">Pending</span>
                                @endif
                            </td>

                            <td class="p-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('submission.document', $sub->id) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 text-sm underline mr-2 font-semibold">
                                        View PDF
                                    </a>

                                    @if ($sub->manager_status != 'finalized')
                                        <form action="{{ route('manager.submission.finalize', $sub->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                                Finalize
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('manager.schedule.create', $sub->id) }}"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition flex items-center">
                                            📅 Schedule
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                No submissions ready for review yet.<br>
                                <span class="text-xs">(Waiting for Supervisors to approve student requests)</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
