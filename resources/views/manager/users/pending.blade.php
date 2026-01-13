@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Pending User Validations</h2>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3 capitalize">{{ $user->role }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">
                            <form action="{{ url('/manager/users/' . $user->id . '/approve') }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    Validate & Approve
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">No pending users.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
