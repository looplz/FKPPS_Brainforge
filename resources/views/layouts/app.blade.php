<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKPPS - Postgraduate Presentation System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-900 text-white p-1.5 rounded-lg shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                            </path>
                        </svg>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="font-bold text-xl text-gray-800 tracking-tight hover:text-blue-900 transition">FKPPS</a>
                </div>

                <div class="flex items-center gap-1">

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-900 hover:bg-blue-50 rounded-md transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg> Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-900 hover:bg-blue-50 rounded-md transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg> My Profile
                        </a>

                        @if (auth()->user()->role == 'manager')
                            <div class="h-5 w-px bg-gray-300 mx-2"></div>
                            <a href="{{ route('manager.users') }}"
                                class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-900 hover:bg-blue-50 rounded-md transition">Users</a>
                            <a href="{{ route('manager.submissions') }}"
                                class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-blue-900 hover:bg-blue-50 rounded-md transition">Submissions</a>
                        @endif

                        <div class="ml-4 pl-4 border-l border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="group flex items-center gap-2 bg-white text-red-500 px-4 py-1.5 rounded-full text-sm font-bold border border-red-200 hover:bg-red-600 hover:text-white hover:border-red-600 transition shadow-sm">
                                    <span>Logout</span>
                                    <svg class="w-4 h-4 opacity-70 group-hover:opacity-100" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold text-blue-900 hover:underline mr-4">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-900 text-white px-4 py-2 rounded-md text-sm font-bold shadow hover:bg-blue-800 transition">Register</a>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <span class="text-2xl cursor-pointer"
                        onclick="this.parentElement.style.display='none';">&times;</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Faculty of Computing, UMPSA. All rights reserved.
        </div>
    </footer>
</body>

</html>
