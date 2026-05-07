<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-700 text-sm font-semibold tracking-wide shadow-sm hover:border-senac-orange hover:text-senac-orange focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange disabled:opacity-40 transition']) }}>
    {{ $slot }}
</button>
