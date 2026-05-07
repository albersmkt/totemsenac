@extends('layouts.admin')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Pendente',
            'draft' => 'Rascunho',
            'published' => 'Publicado',
            'archived' => 'Arquivado',
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="font-display text-2xl text-slate-900">Ações</h2>
        <a href="{{ route('admin.actions.create') }}" class="px-4 py-2 rounded-full bg-senac-orange text-white font-semibold">Nova Acao</a>
    </div>

    <form method="GET" class="mb-6 flex gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Buscar por titulo" class="w-full rounded-full border-slate-200">
        <button class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Buscar</button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left px-4 py-3">Titulo</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Data</th>
                    <th class="text-right px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($actions as $action)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $action->title }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $statusLabels[$action->status] ?? ucfirst($action->status) }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $action->start_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.actions.edit', $action) }}" class="text-senac-blue font-semibold">Editar</a>
                            <form method="POST" action="{{ route('admin.actions.destroy', $action) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 font-semibold" onclick="return confirm('Remover acao?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Nenhuma acao cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $actions->links() }}
    </div>
@endsection
