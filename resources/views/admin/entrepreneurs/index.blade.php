@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h2 class="font-display text-2xl text-slate-900">Empreendedores</h2>
        <a href="{{ route('admin.entrepreneurs.create') }}" class="px-4 py-2 rounded-full bg-slate-700 text-white font-semibold">Novo Empreendedor</a>
    </div>

    <form method="GET" class="mb-6 flex gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Buscar por nome" class="w-full rounded-full border-slate-200">
        <button class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Buscar</button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="text-left px-4 py-3">Nome/Negocio</th>
                    @role('super_admin')
                        <th class="text-left px-4 py-3">Aluno</th>
                    @endrole
                    <th class="text-left px-4 py-3">Categoria</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entrepreneurs as $entrepreneur)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $entrepreneur->display_name }}</td>
                        @role('super_admin')
                            <td class="px-4 py-3 text-slate-600">
                                {{ $entrepreneur->creator?->name ?? 'Nao informado' }}
                            </td>
                        @endrole
                        <td class="px-4 py-3 text-slate-600">
                            {{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ ucfirst($entrepreneur->status) }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.entrepreneurs.edit', $entrepreneur) }}" class="text-senac-blue font-semibold">Editar</a>
                            <form method="POST" action="{{ route('admin.entrepreneurs.destroy', $entrepreneur) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 font-semibold" onclick="return confirm('Remover empreendedor?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasRole('super_admin') ? 5 : 4 }}" class="px-4 py-6 text-center text-slate-500">
                            Nenhum empreendedor cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $entrepreneurs->links() }}
    </div>
@endsection
