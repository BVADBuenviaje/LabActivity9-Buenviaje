@props([
    'title' => null,
    'subtitle' => null,
])

<section {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden']) }}>
    @if ($title)
        <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">
                    {{ $title }}
                </h2>
                @if ($subtitle)
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</section>
