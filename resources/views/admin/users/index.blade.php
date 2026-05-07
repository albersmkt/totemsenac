@extends('layouts.admin')

@section('content')
    @php
        $roleLabels = [
            'super_admin' => 'Super Admin',
            'operador' => 'Operador',
            'estudante' => 'Estudante',
        ];
        $badgeClasses = [
            'super_admin' => 'bg-senac-blue text-white',
            'operador' => 'bg-senac-orange text-white',
            'estudante' => 'bg-slate-200 text-slate-700',
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-display text-slate-900">Usuarios por nivel</h2>
            <p class="mt-2 text-sm text-slate-500">Visualize e gerencie as contas por perfil de acesso.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Novo usuario</a>
    </div>

    <div class="totem-card p-4 mb-6">
        <div class="flex flex-wrap gap-2 text-sm font-semibold">
            @php
                $filters = [
                    'todos' => 'Todos',
                    'super_admin' => 'Super Admin',
                    'operador' => 'Operador',
                    'estudante' => 'Estudante',
                ];
            @endphp
            @foreach ($filters as $key => $label)
                @php
                    $isActive = $selectedRole === $key;
                    $classes = $isActive
                        ? 'px-4 py-2 rounded-full bg-senac-orange text-white'
                        : 'px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 hover:border-senac-orange';
                @endphp
                <a href="{{ route('admin.users.index', ['role' => $key]) }}" class="{{ $classes }}">
                    {{ $label }}
                    <span class="ml-2 inline-flex items-center rounded-full bg-white/20 px-2 py-0.5 text-xs font-semibold">
                        {{ $counts[$key] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="totem-card p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 uppercase tracking-widest text-xs">
                        <th class="pb-3">Usuario</th>
                        <th class="pb-3">Email</th>
                        <th class="pb-3">Nivel de acesso</th>
                        <th class="pb-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-slate-100">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    @if ($user->photo)
                                        <div class="h-10 w-10 rounded-full overflow-hidden bg-senac-sand flex items-center justify-center shrink-0" style="width:40px;height:40px;overflow:hidden;border-radius:9999px;">
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover" width="40" height="40" style="width:100%;height:100%;object-fit:cover;display:block;">
                                        </div>
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-senac-sand text-senac-blue flex items-center justify-center font-semibold shrink-0" style="width:40px;height:40px;border-radius:9999px;">
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">Criado em {{ $user->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-slate-700">{{ $user->email }}</td>
                            <td class="py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->roles as $role)
                                        @php
                                            $label = $roleLabels[$role->name] ?? $role->name;
                                            $badge = $badgeClasses[$role->name] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 rounded-full border border-slate-200 text-xs font-semibold text-slate-600 hover:border-senac-orange">Editar</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Deseja remover este usuario?');">
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
                                Nenhum usuario encontrado para este nivel.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection
