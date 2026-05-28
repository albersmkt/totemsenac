@extends('layouts.totem')

@php
    $totemRouteParams = request()->query('unidade') ? ['unidade' => request()->query('unidade')] : [];
@endphp

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="font-display text-3xl text-slate-900">{{ $entrepreneur->display_name }}</h2>
        <a href="{{ route('totem.entrepreneurs.index', $totemRouteParams) }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="totem-card">
            <div class="h-72 bg-slate-100">
                @if ($entrepreneur->images->first())
                    <img src="{{ asset('storage/' . $entrepreneur->images->first()->path) }}" alt="{{ $entrepreneur->display_name }}" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20"></div>
                @endif
            </div>
            <div class="p-6 space-y-4">
                <span class="px-3 py-1 rounded-full bg-senac-sand text-slate-700 font-semibold text-sm">
                    {{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}
                </span>
                @if ($entrepreneur->description)
                    <p class="text-lg text-slate-700 leading-relaxed">{!! nl2br(e($entrepreneur->description)) !!}</p>
                @else
                    <p class="text-slate-500">Descricao nao informada.</p>
                @endif
                <p class="text-sm text-slate-500">WhatsApp: {{ $entrepreneur->whatsapp_number }}</p>
            </div>
        </div>

        <div class="totem-card p-6 flex flex-col items-center justify-center text-center">
            <p class="text-sm uppercase tracking-widest text-slate-400">Fale com o empreendedor</p>
            <h3 class="mt-2 font-display text-2xl text-slate-900">Escaneie o QR Code</h3>
            <img src="{{ $qrCodeDataUri }}" alt="QR Code WhatsApp" class="mt-6 w-60 h-60">
            <p class="mt-4 text-sm text-slate-500">
                Aponte a camera do seu celular para abrir o WhatsApp com a mensagem pronta.
            </p>
        </div>
    </div>

    @if ($entrepreneur->images->count() > 1)
        <div class="grid grid-cols-2 gap-4 mt-8">
            @foreach ($entrepreneur->images->slice(1) as $image)
                <div class="totem-card">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Foto {{ $entrepreneur->display_name }}" class="w-full h-48 object-cover">
                </div>
            @endforeach
        </div>
    @endif
@endsection
