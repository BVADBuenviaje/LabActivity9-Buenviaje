@props([
    'title',
    'value',
    'subtitle' => null,
    'badge' => null,
    'variant' => 'emerald',
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200 border-l-4 border-l-emerald-600 bg-white p-5 shadow-sm flex flex-col justify-between gap-2']) }}>
    <div class="flex items-start justify-between gap-2">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
            {{ $title }}
        </p>
        @if ($badge)
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border bg-emerald-50 text-emerald-700 border-emerald-200">
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
