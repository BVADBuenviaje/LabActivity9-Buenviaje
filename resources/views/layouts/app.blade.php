<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bakuna Tracker - Purok Buenviaje')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col font-sans antialiased">
    {{-- Header --}}
    <header class="bg-emerald-900 text-white shadow-md border-b border-emerald-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-700 border border-emerald-500 flex items-center justify-center font-black text-lg tracking-tight shrink-0">
                    BT
                </div>
                <div>
                    <a href="{{ route('home') }}" class="text-lg sm:text-xl font-extrabold tracking-tight text-white hover:text-emerald-200 transition">
                        Bakuna Tracker - Purok Buenviaje
                    </a>
                    <p class="text-xs text-emerald-200">
                        Barangay Matina Crossing Health Center &middot; Nurse Marites Abellana, RN
                    </p>
                </div>
            </div>

            <nav aria-label="Primary Navigation" class="flex flex-wrap items-center gap-3 sm:gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-1.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-emerald-700 text-white shadow-sm' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('schedule') }}"
                       class="px-3 py-1.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('schedule') ? 'bg-emerald-700 text-white shadow-sm' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                        Schedule
                    </a>
                    <span class="hidden sm:inline-block text-emerald-600">|</span>
                    <span class="text-sm font-medium text-emerald-100 bg-emerald-800/80 px-3 py-1 rounded-full border border-emerald-700">
                        Hi, {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3.5 py-1.5 rounded-lg text-sm font-semibold bg-emerald-800 hover:bg-emerald-700 text-emerald-100 hover:text-white border border-emerald-600 shadow-sm transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-sm transition">
                        Sign in
                    </a>
                @endguest
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
            <p class="font-medium text-slate-600">
                Bakuna Tracker - Purok Buenviaje &middot; Barangay Matina Crossing Health Center
            </p>
            <p>
                Supervised by Nurse Marites Abellana &middot; Community Immunization Registry (2026)
            </p>
        </div>
    </footer>
</body>
</html>
