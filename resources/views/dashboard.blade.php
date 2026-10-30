@extends('layouts.app')

@section('title', 'Bakuna Tracker - Purok Buenviaje')

@section('content')
    <div class="space-y-8">
        <!-- Hero & Health Center Banner -->
        <section class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-800 rounded-2xl p-6 sm:p-8 text-white shadow-md flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-700/80 text-emerald-100 border border-emerald-500/40">
                    Barangay Matina Crossing Health Center
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Bakuna Tracker - Purok Buenviaje
                </h1>
                <p class="text-sm text-emerald-100 max-w-2xl leading-relaxed">
                    Community Immunization Dashboard for Nurse Marites Abellana's Barangay Health Center. Monitoring BCG, Pentavalent, OPV, MMR, Anti-Flu, PCV-13, and Hepatitis B vaccination schedules across Purok Buenviaje.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('schedule') }}"
                   class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 font-bold text-sm shadow-sm transition">
                    View Full Schedule ({{ $totalVaccinations }})
                </a>
            </div>
        </section>

        {{-- Conditional Alert Banner --}}
        <x-panel title="Immunization Status Advisory" subtitle="Real-time Purok Buenviaje cold-chain & follow-up alerts">
            @if ($pendingCount > 0)
                <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-amber-900">
                            Follow-Up Required: {{ $pendingCount }} Pending Vaccination {{ $pendingCount === 1 ? 'Record' : 'Records' }}
                        </p>
                        <p class="text-xs text-amber-800">
                            Barangay Health Workers in Purok Buenviaje need to confirm household reminders for pending immunization doses.
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-200/80 text-amber-900 shrink-0">
                        Action Needed
                    </span>
                </div>
            @elseif ($scheduledCount > 0)
                <div class="rounded-xl bg-sky-50 border border-sky-200 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-sky-900">
                            Upcoming Clinic Sessions: {{ $scheduledCount }} Scheduled {{ $scheduledCount === 1 ? 'Patient' : 'Patients' }}
                        </p>
                        <p class="text-xs text-sky-800">
                            All vaccine vials are stocked and ready for upcoming scheduled appointments at Barangay Matina Crossing Health Center.
                        </p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-200/80 text-sky-900 shrink-0">
                        On Track
                    </span>
                </div>
            @else
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                    <p class="text-sm font-bold text-emerald-900">
                        All Purok Buenviaje Vaccination Doses Completed!
                    </p>
                    <p class="text-xs text-emerald-700 mt-0.5">
                        Every registered resident has completed their scheduled immunization dose for 2026.
                    </p>
                </div>
            @endif

            @unless ($vaccinations->isEmpty())
                <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                    <span>
                        Active Vaccines in Registry:
                        @foreach ($distinctVaccines as $vaccineName)
                            <strong class="text-slate-800">{{ $vaccineName }}</strong>{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </span>
                    <span class="font-semibold text-emerald-700">
                        Purok Buenviaje Coverage: {{ $purokBuenviajeCount }} of {{ $totalVaccinations }} records
                    </span>
                </div>
            @endunless
        </x-panel>

        <!-- Summary Stat Cards (Responsive CSS Grid: md:grid-cols-4) -->
        <section aria-label="Vaccination Statistics" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <x-stat-card
                title="Total Registered Doses"
                :value="$totalVaccinations"
                subtitle="2026 Master Immunization List"
                badge="All Puroks"
                variant="emerald"
            />
            <x-stat-card
                title="Completed Doses"
                :value="$completedCount"
                subtitle="Administered & verified"
                badge="Administered"
                variant="emerald"
            />
            <x-stat-card
                title="Scheduled Appointments"
                :value="$scheduledCount"
                subtitle="Confirmed clinic dates"
                badge="Upcoming"
                variant="sky"
            />
            <x-stat-card
                title="Pending Follow-Ups"
                :value="$pendingCount"
                subtitle="Awaiting household visit"
                badge="Needs Follow-Up"
                variant="amber"
            />
        </section>

        {{-- Vaccination Schedule Table --}}
        <x-panel title="Purok Buenviaje & Barangay Immunization Schedule" subtitle="Showing all seeded 2026 patient vaccination records">
            <x-slot:actions>
                <a href="{{ route('schedule') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-600 underline">
                    Open Dedicated Schedule View &rarr;
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
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
                                            {{ $vaccination->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
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
