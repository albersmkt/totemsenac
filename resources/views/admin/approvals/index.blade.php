@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Aprovações</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="totem-card p-6">
            <h3 class="font-display text-xl text-slate-900 mb-4">Ações Pendentes</h3>
            <div class="space-y-4">
                @forelse ($pendingActions as $action)
                    <div class="border border-slate-100 rounded-xl p-4">
                        <a href="{{ route('admin.approvals.actions.show', $action) }}" class="block text-left w-full group">
                            <p class="font-semibold text-slate-900">{{ $action->title }}</p>
                            <p class="text-sm text-slate-500">{{ $action->start_at->format('d/m/Y H:i') }}</p>
                            <span class="mt-1 inline-flex text-xs font-semibold text-senac-orange group-hover:underline">Ver detalhes</span>
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Operador: {{ $action->creator?->name ?? 'Nao informado' }}</p>
                        <p class="text-xs text-slate-400">Unidade: {{ $action->unidade?->nome ?? 'Nao informada' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.approvals.actions.show', $action) }}" class="px-3 py-1 rounded-full border border-slate-200 text-slate-600 text-sm">
                                Detalhes
                            </a>
                            <form method="POST" action="{{ route('admin.approvals.actions.approve', $action) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-emerald-600 text-white text-sm">Aprovar</button>
                            </form>
                            <form method="POST" action="{{ route('admin.approvals.actions.reject', $action) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-rose-600 text-white text-sm">Reprovar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">Nenhuma ação pendente.</p>
                @endforelse
            </div>
        </div>

        <div class="totem-card p-6">
            <h3 class="font-display text-xl text-slate-900 mb-4">Eventos Pendentes</h3>
            <div class="space-y-4">
                @forelse ($pendingEvents as $event)
                    <div class="border border-slate-100 rounded-xl p-4">
                        <a href="{{ route('admin.approvals.events.show', $event) }}" class="block text-left w-full group">
                            <p class="font-semibold text-slate-900">{{ $event->title }}</p>
                            <p class="text-sm text-slate-500">{{ $event->start_at->format('d/m/Y H:i') }}</p>
                            <span class="mt-1 inline-flex text-xs font-semibold text-senac-orange group-hover:underline">Ver detalhes</span>
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Operador: {{ $event->creator?->name ?? 'Nao informado' }}</p>
                        <p class="text-xs text-slate-400">Unidade: {{ $event->unidade?->nome ?? 'Nao informada' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.approvals.events.show', $event) }}" class="px-3 py-1 rounded-full border border-slate-200 text-slate-600 text-sm">
                                Detalhes
                            </a>
                            <form method="POST" action="{{ route('admin.approvals.events.approve', $event) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-emerald-600 text-white text-sm">Aprovar</button>
                            </form>
                            <form method="POST" action="{{ route('admin.approvals.events.reject', $event) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-rose-600 text-white text-sm">Reprovar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">Nenhum evento pendente.</p>
                @endforelse
            </div>
        </div>

        <div class="totem-card p-6">
            <h3 class="font-display text-xl text-slate-900 mb-4">Empreendedores Pendentes</h3>
            <div class="space-y-4">
                @forelse ($pendingEntrepreneurs as $entrepreneur)
                    <div class="border border-slate-100 rounded-xl p-4">
                        <a href="{{ route('admin.approvals.entrepreneurs.show', $entrepreneur) }}" class="block text-left w-full group">
                            <p class="font-semibold text-slate-900">{{ $entrepreneur->display_name }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}
                            </p>
                            <span class="mt-1 inline-flex text-xs font-semibold text-senac-orange group-hover:underline">Ver detalhes</span>
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Aluno: {{ $entrepreneur->creator?->name ?? 'Nao informado' }}</p>
                        <p class="text-xs text-slate-400">Unidade: {{ $entrepreneur->unidade?->nome ?? 'Nao informada' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.approvals.entrepreneurs.show', $entrepreneur) }}" class="px-3 py-1 rounded-full border border-slate-200 text-slate-600 text-sm">
                                Detalhes
                            </a>
                            <form method="POST" action="{{ route('admin.approvals.entrepreneurs.approve', $entrepreneur) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-emerald-600 text-white text-sm">Aprovar</button>
                            </form>
                            <form method="POST" action="{{ route('admin.approvals.entrepreneurs.reject', $entrepreneur) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-rose-600 text-white text-sm">Reprovar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">Nenhum empreendedor pendente.</p>
                @endforelse
            </div>
        </div>

        <div class="totem-card p-6">
            <h3 class="font-display text-xl text-slate-900 mb-4">Projetos Pendentes</h3>
            <p class="text-xs text-slate-500 mb-4">Clique no titulo para ver detalhes antes de aprovar.</p>
            <div class="space-y-4">
                @forelse ($pendingProjects as $project)
                    @php
                        $integrantes = $project->memberNamesFromText();
                    @endphp
                    <div class="border border-slate-100 rounded-xl p-4">
                        <a href="{{ route('admin.approvals.projects.show', $project) }}" class="block text-left w-full group">
                            <p class="font-semibold text-slate-900">{{ $project->title }}</p>
                            <p class="text-sm text-slate-500">{{ $project->course }} - {{ $project->class_group }}</p>
                            <p class="text-xs text-slate-400">Área: {{ $project->area?->name ?? 'Não informada' }}</p>
                            <span class="mt-1 inline-flex text-xs font-semibold text-senac-orange group-hover:underline">Ver detalhes</span>
                        </a>
                        <p class="text-xs text-slate-400 mt-1">Aluno: {{ $project->creator?->name ?? 'Nao informado' }}</p>
                        <p class="text-xs text-slate-400">Unidade: {{ $project->unidade?->nome ?? 'Nao informada' }}</p>
                        @if (count($integrantes))
                            <p class="text-xs text-slate-400 mt-1">
                                Integrantes: {{ implode(', ', $integrantes) }}
                            </p>
                        @elseif ($project->members->count())
                            <p class="text-xs text-slate-400 mt-1">
                                Integrantes: {{ $project->members->pluck('name')->implode(', ') }}
                            </p>
                        @endif
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.approvals.projects.show', $project) }}" class="px-3 py-1 rounded-full border border-slate-200 text-slate-600 text-sm">
                                Detalhes
                            </a>
                            <form method="POST" action="{{ route('admin.approvals.projects.approve', $project) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-emerald-600 text-white text-sm">Aprovar</button>
                            </form>
                            <form method="POST" action="{{ route('admin.approvals.projects.reject', $project) }}">
                                @csrf
                                <button class="px-3 py-1 rounded-full bg-rose-600 text-white text-sm">Reprovar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500">Nenhum projeto pendente.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
