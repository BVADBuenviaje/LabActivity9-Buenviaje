@extends('layouts.app')

@section('title', 'Sign In · Bakuna Tracker - Purok Buenviaje')

@section('content')
    <div class="min-h-[calc(100vh-8rem)] flex-1 flex flex-col justify-center items-center w-full pb-12 sm:pb-16">
        <section class="max-w-md w-full mx-auto">
            <x-panel title="Health Worker Portal Sign In" subtitle="Barangay Matina Crossing Health Center · Purok Buenviaje">
            @unless (auth()->check())
                <div class="mb-5 rounded-xl bg-emerald-50 border border-emerald-200 p-3.5 text-xs text-emerald-800">
                    <p class="font-bold">Authorized Health Center Access Only</p>
                    <p class="mt-0.5 text-emerald-700">
                        Sign in with your assigned Barangay Bakuna Tracker credentials to view and manage Purok Buenviaje immunization records.
                    </p>
                </div>
            @endunless

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Health Worker Email
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
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        placeholder="Enter your password"
                        class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-600/20"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs text-slate-600">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer">
                        <input id="remember" name="remember" type="checkbox" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span>Keep session active on this workstation</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold py-2.5 px-4 text-sm shadow-sm transition cursor-pointer"
                >
                    Sign in to Bakuna Tracker
                </button>
            </form>
        </x-panel>
        </section>
    </div>
@endsection
