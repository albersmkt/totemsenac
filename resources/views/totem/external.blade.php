@extends('layouts.embed')

@section('content')
    <div class="w-full max-w-xl totem-card p-6 text-center space-y-4">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Link externo</p>
        <h1 class="font-display text-2xl text-slate-900">Abra no celular</h1>
        <p class="text-sm text-slate-500">
            Por seguranca, este link nao abre dentro do totem.
        </p>
        <p class="text-xs text-slate-400">{{ $host }}</p>
        <img src="{{ $qrCodeDataUri }}" alt="QR Code link externo" class="mx-auto w-48 h-48">
        <div class="flex flex-wrap items-center justify-center gap-2">
            <button type="button" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600" onclick="history.back()">
                Voltar
            </button>
        </div>
    </div>
@endsection
