@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' =>
        'rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-300 focus:border-gray-400 focus:ring-2 focus:ring-gray-100 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400'
]) }}>