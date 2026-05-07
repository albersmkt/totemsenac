<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-senac-orange text-white text-sm font-semibold tracking-wide shadow-sm hover:bg-[#e65f1c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange transition']) }}>
    {{ $slot }}
</button>
