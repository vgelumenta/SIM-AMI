<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex px-4 py-2 bg-blue-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
