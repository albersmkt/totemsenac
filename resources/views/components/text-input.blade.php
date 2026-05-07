@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border-slate-200 bg-white text-slate-900 shadow-sm focus:border-senac-orange focus:ring-senac-orange']) }}>
