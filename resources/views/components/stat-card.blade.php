@props([
    'title',
    'value',
    'subtitle' => null,
    'badge' => null,
    'variant' => 'emerald',
])

@php
    $accentStyles = match ($variant) {
        'amber' => 'border-l-4 border-l-amber-500 bg-white',
        'sky' => 'border-l-4 border-l-sky-500 bg-white',
        'rose' => 'border-l-4 border-l-rose-500 bg-white',
        default => 'border-l-4 border-l-emerald-600 bg-white',
    };

    $badgeStyles = match ($variant) {
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200',
        'sky' => 'bg-sky-50 text-sky-700 border-sky-200',
        'rose' => 'bg-rose-50 text-rose-700 border-rose-200',
        default => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between gap-2 $accentStyles"]) }}>
    <div class="flex items-start justify-between gap-2">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
            {{ $title }}
        </p>
        @if ($badge)
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $badgeStyles }}">
                {{ $badge }}
            </span>
        @endif
    </div>

    <div class="mt-1">
        <p class="text-3xl font-black tracking-tight text-slate-900">
            {{ $value }}
        </p>
        @if ($subtitle)
            <p class="text-xs text-slate-500 mt-1">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</div>
