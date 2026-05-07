@extends('layouts.totem')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-display text-3xl text-senac-blue">Empreendedores</h2>
        <a href="{{ route('totem.home') }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Negocios</p>
                <h3 class="font-display text-xl text-slate-900">Empreendedores</h3>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6">
            @forelse ($entrepreneurs as $entrepreneur)
                <a href="{{ route('totem.entrepreneurs.show', $entrepreneur) }}" class="totem-card">
                    <div class="h-48 bg-slate-100">
                        @if ($entrepreneur->images->first())
                            <img src="{{ asset('storage/' . $entrepreneur->images->first()->path) }}" alt="{{ $entrepreneur->display_name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20"></div>
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-widest text-slate-400">
                            {{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}
                        </p>
                        <h3 class="mt-2 font-semibold text-lg text-slate-900">{{ $entrepreneur->display_name }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ Str::limit($entrepreneur->description ?? '', 140) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhum empreendedor aprovado ainda.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-8">
        {{ $entrepreneurs->links() }}
    </div>
@endsection
