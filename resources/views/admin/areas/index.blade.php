@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-display text-slate-900">Áreas</h2>
            <p class="mt-2 text-sm text-slate-500">Gerencie as áreas disponíveis para organização dos conteúdos.</p>
        </div>
        <a href="{{ route('admin.areas.create') }}" class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Nova área</a>
    </div>

    <div class="totem-card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Buscar por nome da área"
                class="flex-1 min-w-[240px] rounded-xl border-slate-200"
            >
            <button class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Buscar</button>
            @if ($q !== '')
                <a href="{{ route('admin.areas.index') }}" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Limpar</a>
            @endif
        </form>
    </div>

    <div class="totem-card p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 uppercase tracking-widest text-xs">
                        <th class="pb-3">Área</th>
                        <th class="pb-3">Slug</th>
                        <th class="pb-3">Criada em</th>
                        <th class="pb-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($areas as $area)
                        <tr class="border-t border-slate-100">
                            <td class="py-4 font-semibold text-slate-900">{{ $area->name }}</td>
                            <td class="py-4 text-slate-600">{{ $area->slug }}</td>
                            <td class="py-4 text-slate-600">{{ $area->created_at?->format('d/m/Y') }}</td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.areas.edit', $area) }}" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold text-slate-600 hover:border-senac-orange">Editar</a>
                                    <form method="POST" action="{{ route('admin.areas.destroy', $area) }}" onsubmit="return confirm('Deseja remover esta área?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-full bg-rose-600 text-white text-xs font-semibold">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-500">
                                Nenhuma área cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $areas->links() }}
        </div>
    </div>
@endsection
