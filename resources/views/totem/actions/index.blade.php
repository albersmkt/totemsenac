@extends('layouts.totem')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-display text-3xl text-senac-blue">Ações</h2>
        <a href="{{ route('totem.home') }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Programacao</p>
                <h3 class="font-display text-xl text-slate-900">Ações publicadas</h3>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6">
            @forelse ($actions as $action)
                <a href="{{ route('totem.actions.show', $action) }}" class="totem-card">
                    <div class="h-48 bg-slate-100">
                        @if ($action->cover_image)
                            <img src="{{ asset('storage/' . $action->cover_image) }}" alt="{{ $action->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-widest text-slate-400">{{ $action->start_at->format('d/m/Y') }}</p>
                        <h3 class="mt-2 font-semibold text-lg text-slate-900">{{ $action->title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ Str::limit($action->description, 140) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhuma acao publicada ainda.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-8">
        {{ $actions->links() }}
    </div>
@endsection
