@extends('layouts.app')

@section('title', 'Sign In · Bakuna Tracker - Purok Buenviaje')

@section('content')
    {{-- // login --}}
    <div class="min-h-[calc(100vh-8rem)] flex-1 flex flex-col justify-center items-center w-full pb-12 sm:pb-16">
        <section class="max-w-md w-full mx-auto">
            <x-panel title="Health Worker Sign In" subtitle="Barangay Matina Crossing Health Center">
                @unless (auth()->check())
                    <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-3.5 text-xs text-emerald-800">
                        <p class="font-bold">Authorized Access</p>
                        <p class="mt-0.5 text-emerald-700">
                            Sign in with your credentials to manage Purok Buenviaje records.
                        </p>
                    </div>
                @endunless

                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', 'nurse.buenviaje@bakuna.test') }}"
                            required
                            autofocus
                            placeholder="nurse.buenviaje@bakuna.test"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20"
                        >
                        @error('email')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="Enter password"
                                class="w-full rounded-xl border border-slate-300 bg-white pl-3.5 pr-10 py-2.5 text-sm text-slate-900 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20"
                            >
                            <button
                                type="button"
                                onclick="togglePasswordVisibility()"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-emerald-700 transition cursor-pointer"
                                aria-label="Toggle password visibility"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-600">
                        <label for="remember" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember" name="remember" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span>Remember me</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-2.5 px-4 text-sm shadow-sm transition cursor-pointer"
                    >
                        Sign In
                    </button>
                </form>
            </x-panel>
        </section>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            const eyeSlash = document.getElementById('eyeSlashIcon');
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.add('hidden');
                eyeSlash.classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.classList.remove('hidden');
                eyeSlash.classList.add('hidden');
            }
        }
    </script>
@endsection
