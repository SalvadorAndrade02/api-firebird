@props(['status'])

@if ($status)

    <div {{ $attributes->merge([
            'class' =>
                'flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700'
        ]) }}>

        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-xs font-semibold">
            ✓
        </div>

        <div>
            {{ $status }}
        </div>

    </div>

@endif