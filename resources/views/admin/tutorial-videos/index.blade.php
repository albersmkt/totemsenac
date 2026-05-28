@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-display text-slate-900">Tutoriais</h2>
            <p class="mt-2 text-sm text-slate-500">Cadastre vídeos do YouTube para orientar operadores e alunos no uso do sistema.</p>
        </div>
        <a href="{{ route('admin.tutorial-videos.create') }}" class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Novo vídeo</a>
    </div>

    <div class="totem-card p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Buscar por título"
                class="flex-1 min-w-[220px] rounded-xl border-slate-200"
            >
            <select name="role" class="rounded-xl border-slate-200">
                <option value="">Todos os públicos</option>
                <option value="operador" @selected($role === 'operador')>Operador</option>
                <option value="estudante" @selected($role === 'estudante')>Aluno</option>
            </select>
            <button class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Buscar</button>
            @if ($q !== '' || $role)
                <a href="{{ route('admin.tutorial-videos.index') }}" class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Limpar</a>
            @endif
        </form>
    </div>

    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.tutorial.index', ['role' => 'operador']) }}" class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Visualizar como operador</a>
        <a href="{{ route('admin.tutorial.index', ['role' => 'estudante']) }}" class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Visualizar como aluno</a>
    </div>

    <div class="totem-card p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 uppercase tracking-widest text-xs">
                        <th class="pb-3">Vídeo</th>
                        <th class="pb-3">Público</th>
                        <th class="pb-3">Posição</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($videos as $video)
                        <tr class="border-t border-slate-100">
                            <td class="py-4">
                                <div class="font-semibold text-slate-900">{{ $video->title }}</div>
                                <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-senac-blue">Abrir no YouTube</a>
                            </td>
                            <td class="py-4 text-slate-600">{{ $video->audienceLabel() }}</td>
                            <td class="py-4 text-slate-600">Aula {{ $video->sort_order }}</td>
                            <td class="py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $video->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $video->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.tutorial-videos.edit', $video) }}" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold text-slate-600 hover:border-senac-orange">Editar</a>
                                    <form method="POST" action="{{ route('admin.tutorial-videos.destroy', $video) }}" onsubmit="return confirm('Deseja remover este vídeo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-full bg-rose-600 text-white text-xs font-semibold">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Nenhum vídeo cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $videos->links() }}
        </div>
    </div>
@endsection
