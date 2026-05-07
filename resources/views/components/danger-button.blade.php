<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-rose-600 text-white text-sm font-semibold tracking-wide shadow-sm hover:bg-rose-500 active:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition']) }}>
    {{ $slot }}
</button>
