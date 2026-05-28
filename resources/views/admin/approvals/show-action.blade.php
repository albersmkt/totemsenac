@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Ação</p>
            <h2 class="font-display text-3xl text-slate-900">{{ $action->title }}</h2>
            <p class="text-sm text-slate-500">{{ $action->start_at?->format('d/m/Y H:i') }}@if($action->end_at) ate {{ $action->end_at->format('d/m/Y H:i') }}@endif</p>
        </div>
        <a href="{{ route('admin.approvals.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-700 font-semibold">Voltar</a>
    </div>

    <div class="totem-card p-6 space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs uppercase tracking-[0.2em]">{{ strtoupper($action->status) }}</span>
            <span class="text-xs text-slate-400">Operador: {{ $action->creator?->name ?? 'Nao informado' }}</span>
            @if ($action->location)
                <span class="text-xs text-slate-400">Local: {{ $action->location }}</span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-6">
            <div class="rounded-2xl overflow-hidden bg-slate-100">
                @if ($action->cover_image)
                    <img src="{{ asset('storage/' . $action->cover_image) }}" alt="{{ $action->title }}" class="w-full h-72 object-cover">
                @else
                    <div class="h-72 bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                @endif
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Descrição</p>
                <p class="text-sm text-slate-600 leading-relaxed">{!! nl2br(e($action->description)) !!}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        @if ($action->status === 'pending')
            <form method="POST" action="{{ route('admin.approvals.actions.approve', $action) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-emerald-600 text-white font-semibold">Aprovar</button>
            </form>
            <form method="POST" action="{{ route('admin.approvals.actions.reject', $action) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-rose-600 text-white font-semibold">Reprovar</button>
            </form>
        @endif
    </div>
@endsection
