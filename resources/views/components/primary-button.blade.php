<button {{ $attributes->merge([
    'type' => 'submit',

    'class' =>
        'inline-flex items-center rounded-xl border border-transparent bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 active:bg-gray-900 disabled:cursor-not-allowed disabled:opacity-50'
]) }}>
    {{ $slot }}
</button>