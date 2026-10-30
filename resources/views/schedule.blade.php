@extends('layouts.app')

@section('title', 'Vaccination Schedule · Bakuna Tracker - Purok Buenviaje')

@section('content')
    <div class="space-y-8">
        // header
        <section class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">
                    Barangay Matina Crossing Health Center
                </p>
                <h1 class="text-2xl font-black tracking-tight text-slate-900 mt-1">
                    Master Immunization Schedule &middot; Purok Buenviaje
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    View and filter scheduled vaccine doses.
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition shrink-0">
                &larr; Back to Dashboard
            </a>
        </section>

        // metrics
        <section aria-label="Schedule Summary Counts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <x-stat-card
                title="Total Records"
                :value="$totalVaccinations"
                subtitle="Seeded entries"
                badge="Registry"
            />
            <x-stat-card
                title="Completed"
                :value="$completedCount"
                subtitle="Administered"
                badge="Done"
            />
            <x-stat-card
                title="Scheduled"
                :value="$scheduledCount"
                subtitle="Upcoming appointments"
                badge="Active"
            />
            <x-stat-card
                title="Pending"
                :value="$pendingCount"
                subtitle="Requires follow-up"
                badge="Pending"
            />
        </section>

        // filters
        <x-panel title="Filter Records" subtitle="Filter by purok or status">
            <form method="GET" action="{{ route('schedule') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="purok" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Purok
                    </label>
                    <select id="purok" name="purok" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-emerald-600 focus:outline-none">
                        <option value="">All Puroks</option>
                        @foreach ($puroks as $purokOption)
                            <option value="{{ $purokOption }}" {{ $selectedPurok === $purokOption ? 'selected' : '' }}>
                                {{ $purokOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Status
                    </label>
                    <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-emerald-600 focus:outline-none">
                        <option value="">All Statuses</option>
                        <option value="Completed" {{ $selectedStatus === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Scheduled" {{ $selectedStatus === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Pending" {{ $selectedStatus === 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-sm font-bold shadow-sm transition cursor-pointer">
                        Apply Filter
                    </button>
                    @unless (empty($selectedStatus) && empty($selectedPurok))
                        <a href="{{ route('schedule') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition">
                            Reset
                        </a>
                    @endunless
                </div>
            </form>

            <div class="mt-5">
                @if ($vaccinations->isEmpty())
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-xs text-emerald-900 font-medium">
                        No vaccination schedule records match the filter.
                    </div>
                @elseif ($pendingCount > 0)
                    <div class="rounded-xl bg-emerald-50 border border-emerald-300 p-3.5 text-xs text-emerald-950 font-medium">
                        Notice: {{ $pendingCount }} pending {{ $pendingCount === 1 ? 'immunization awaits' : 'immunizations await' }} confirmation.
                    </div>
                @else
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-3.5 text-xs text-emerald-900">
                        All scheduled records are up to date.
                    </div>
                @endif
            </div>
        </x-panel>

        // schedule
        <x-panel title="Vaccination Schedule Registry" subtitle="Chronological 2026 schedule">
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
                                    No vaccination schedules found for the selected filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-panel>
    </div>
@endsection
