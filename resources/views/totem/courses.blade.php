@extends('layouts.totem')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-display text-3xl text-senac-blue">Cursos</h2>
            <p class="text-sm text-slate-500 mt-2">
                Visualize o site oficial do Senac dentro do totem. Para abrir no celular, use o QR Code.
            </p>
        </div>
        <a href="{{ route('totem.home') }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 totem-card overflow-hidden">
            <iframe
                src="{{ $coursesProxyUrl }}"
                title="Cursos Senac"
                class="w-full h-[70vh] border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            <div class="p-4 text-xs text-slate-500">
                Se o site nao carregar, use o QR Code ao lado para abrir no celular.
            </div>
        </div>

        <div class="totem-card p-6 flex flex-col items-center justify-center text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Acesso rapido</p>
            <h3 class="font-display text-xl text-slate-900 mt-2">Cursos Senac</h3>
            <img src="{{ $qrCodeDataUri }}" alt="QR Code cursos" class="mt-6 w-48 h-48">
            <p class="mt-4 text-sm text-slate-500">
                Escaneie para abrir o site oficial no celular.
            </p>
        </div>
    </div>
@endsection
