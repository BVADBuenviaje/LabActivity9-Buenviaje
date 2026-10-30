@extends('layouts.app')

@section('title', 'Bakuna Tracker - Purok Buenviaje')

@section('content')
    <div class="space-y-8">
        {{-- summary --}}
        <section class="bg-gradient-to-r from-emerald-900 to-emerald-800 rounded-2xl p-6 sm:p-8 text-white shadow-md flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-800 text-emerald-100 border border-emerald-600">
                    Barangay Matina Crossing Health Center
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Bakuna Tracker - Purok Buenviaje
                </h1>
                <p class="text-sm text-emerald-100 max-w-2xl leading-relaxed">
                    Overview of immunization schedules for Purok Buenviaje.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('schedule') }}"
                   class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 font-bold text-sm shadow-sm transition">
                    View Full Schedule ({{ $totalVaccinations }})
                </a>
            </div>
        </section>

        <x-panel title="Immunization Status" subtitle="Current records and follow-ups">
            @if ($pendingCount > 0)
                <div class="rounded-xl bg-emerald-50 border border-emerald-300 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-emerald-950">
                    <div>
                        <p class="text-sm font-bold">
                            Notice: {{ $pendingCount }} pending {{ $pendingCount === 1 ? 'immunization awaits' : 'immunizations await' }} confirmation.
                        </p>
                        <p class="text-xs text-emerald-800 mt-0.5">
                            Barangay Health Workers need to complete scheduled household reminders.
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-700 text-white shrink-0">
                        Action Needed
                    </span>
                </div>
            @elseif ($scheduledCount > 0)
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-emerald-950">
                    <div>
                        <p class="text-sm font-bold">
                            Notice: {{ $scheduledCount }} upcoming clinic {{ $scheduledCount === 1 ? 'session is' : 'sessions are' }} scheduled.
                        </p>
                        <p class="text-xs text-emerald-800 mt-0.5">
                            Vaccine inventory is prepared for scheduled appointments.
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-200 text-emerald-900 shrink-0">
                        On Track
                    </span>
                </div>
            @else
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-900">
                    <p class="text-sm font-bold">
                        All immunization doses completed.
                    </p>
                    <p class="text-xs text-emerald-700 mt-0.5">
                        Every registered resident has completed their scheduled doses.
                    </p>
                </div>
            @endif

            @unless ($vaccinations->isEmpty())
                <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                    <span>
                        Active Vaccines:
                        @foreach ($distinctVaccines as $vaccineName)
                            <strong class="text-slate-800">{{ $vaccineName }}</strong>{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </span>
                    <span class="font-semibold text-emerald-700">
                        Purok Buenviaje: {{ $purokBuenviajeCount }} of {{ $totalVaccinations }} records
                    </span>
                </div>
            @endunless
        </x-panel>

        {{-- metrics --}}
        <section aria-label="Vaccination Statistics" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <x-stat-card
                title="Total Registered Doses"
                :value="$totalVaccinations"
                subtitle="Master list"
                badge="All Puroks"
            />
            <x-stat-card
                title="Completed Doses"
                :value="$completedCount"
                subtitle="Administered"
                badge="Done"
            />
            <x-stat-card
                title="Scheduled Appointments"
                :value="$scheduledCount"
                subtitle="Upcoming clinic dates"
                badge="Active"
            />
            <x-stat-card
                title="Pending Follow-Ups"
                :value="$pendingCount"
                subtitle="Awaiting visit"
                badge="Pending"
            />
        </section>

        {{-- schedule --}}
        <x-panel title="Vaccination Schedule" subtitle="All registered patient records">
            <x-slot:actions>
                <a href="{{ route('schedule') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 underline">
                    Open Schedule View &rarr;
                </a>
            </x-slot:actions>

            <div class="overflow-x-auto -mx-6 px-6">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider font-bold">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-left">#</th>
                            <th scope="col" class="py-3 px-4 text-left">Patient Name</th>
                            <th scope="col" class="py-3 px-4 text-left">Purok / Address</th>
                            <th scope="col" class="py-3 px-4 text-left">Vaccine</th>
                            <th scope="col" class="py-3 px-4 text-left">Dose</th>
                            <th scope="col" class="py-3 px-4 text-left">Scheduled Date</th>
                            <th scope="col" class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($vaccinations as $vaccination)
                            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-slate-50/70' }} hover:bg-emerald-50/40 transition">
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-500">
                                    {{ $loop->iteration }}
                                    @if ($loop->first)
                                        <span class="ml-1 inline-block px-1.5 py-0.5 text-[10px] font-sans font-bold uppercase rounded bg-emerald-100 text-emerald-800">
                                            First
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">
                                    {{ $vaccination->patient_name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-700">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $vaccination->purok === 'Purok Buenviaje' ? 'bg-emerald-100 text-emerald-800 font-semibold' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $vaccination->purok }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 block mt-0.5">{{ $vaccination->address }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-800">
                                    {{ $vaccination->vaccine }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">
                                    {{ $vaccination->dose }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                    {{ $vaccination->scheduled_at->format('M d, Y') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($vaccination->status === 'Completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                            {{ $vaccination->status }}
                                        </span>
                                    @elseif ($vaccination->status === 'Scheduled')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $vaccination->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $vaccination->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 px-4 text-center text-slate-500">
                                    No vaccination schedules found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
@endsection
