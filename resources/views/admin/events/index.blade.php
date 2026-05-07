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
        <h2 class="font-display text-2xl text-slate-900">Eventos</h2>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Novo Evento</a>
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
                @forelse ($events as $event)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $event->title }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $statusLabels[$event->status] ?? ucfirst($event->status) }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $event->start_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-senac-blue font-semibold">Editar</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 font-semibold" onclick="return confirm('Remover evento?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Nenhum evento cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endsection
