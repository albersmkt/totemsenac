@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Empreendedor</p>
            <h2 class="font-display text-3xl text-slate-900">{{ $entrepreneur->display_name }}</h2>
            <p class="text-sm text-slate-500">{{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}</p>
        </div>
        <a href="{{ route('admin.approvals.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-700 font-semibold">Voltar</a>
    </div>

    <div class="totem-card p-6 space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs uppercase tracking-[0.2em]">{{ strtoupper($entrepreneur->status) }}</span>
            <span class="text-xs text-slate-400">Aluno: {{ $entrepreneur->creator?->name ?? 'Nao informado' }}</span>
            <span class="text-xs text-slate-400">WhatsApp: {{ $entrepreneur->whatsapp_number }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-6">
            <div class="rounded-2xl overflow-hidden bg-slate-100">
                @if ($entrepreneur->images->first())
                    <img src="{{ asset('storage/' . $entrepreneur->images->first()->path) }}" alt="{{ $entrepreneur->display_name }}" class="w-full h-72 object-cover">
                @else
                    <div class="h-72 bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                @endif
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Descrição</p>
                <p class="text-sm text-slate-600 leading-relaxed">{!! nl2br(e($entrepreneur->description ?: 'Nao informado.')) !!}</p>
            </div>
        </div>

        @if ($entrepreneur->images->count() > 1)
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-3">Galeria</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($entrepreneur->images->skip(1) as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria {{ $entrepreneur->display_name }}" class="h-32 w-full object-cover rounded-xl">
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        @if ($entrepreneur->status === 'pending')
            <form method="POST" action="{{ route('admin.approvals.entrepreneurs.approve', $entrepreneur) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-emerald-600 text-white font-semibold">Aprovar</button>
            </form>
            <form method="POST" action="{{ route('admin.approvals.entrepreneurs.reject', $entrepreneur) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-rose-600 text-white font-semibold">Reprovar</button>
            </form>
        @endif
    </div>
@endsection
