@extends('layouts.admin')

@section('content')
    @php
        $integrantes = $project->memberNamesFromText();
    @endphp

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Projeto Integrador</p>
            <h2 class="font-display text-3xl text-slate-900">{{ $project->title }}</h2>
            <p class="text-sm text-slate-500">{{ $project->course }} - {{ $project->class_group }}</p>
            <p class="text-sm text-slate-500">Área: {{ $project->area?->name ?? 'Não informada' }}</p>
        </div>
        <a href="{{ route('admin.approvals.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-700 font-semibold">Voltar</a>
    </div>

    <div class="totem-card p-6 space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs uppercase tracking-[0.2em]">{{ strtoupper($project->status) }}</span>
            <span class="text-xs text-slate-400">Aluno: {{ $project->creator?->name ?? 'Nao informado' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] gap-6">
            <div class="rounded-2xl overflow-hidden bg-slate-100">
                @if ($project->cover_image)
                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" class="w-full h-72 object-cover">
                @else
                    <div class="h-72 bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                @endif
            </div>
            <div class="space-y-3 text-sm text-slate-600">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Integrantes</p>
                    @if (count($integrantes))
                        <p class="text-slate-700">{{ implode(', ', $integrantes) }}</p>
                    @elseif ($project->members->count())
                        <p class="text-slate-700">{{ $project->members->pluck('name')->implode(', ') }}</p>
                    @else
                        <p class="text-slate-500">Nao informado.</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Descricao</p>
                    <p class="leading-relaxed">{{ $project->description }}</p>
                </div>
            </div>
        </div>

        @if ($project->images->count())
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-3">Galeria</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($project->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria {{ $project->title }}" class="h-32 w-full object-cover rounded-xl">
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        @if ($project->status === 'pending')
            <form method="POST" action="{{ route('admin.approvals.projects.approve', $project) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-emerald-600 text-white font-semibold">Aprovar</button>
            </form>
            <form method="POST" action="{{ route('admin.approvals.projects.reject', $project) }}">
                @csrf
                <button class="px-4 py-2 rounded-full bg-rose-600 text-white font-semibold">Reprovar</button>
            </form>
        @endif
    </div>
@endsection
