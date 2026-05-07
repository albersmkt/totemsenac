@extends('layouts.admin')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @hasanyrole('super_admin|admin_unidade')
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Ações</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['actions'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Eventos</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['events'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Projetos Integradores</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['projects'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Empreendedores</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['entrepreneurs'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Áreas</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['areas'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Projetos Pendentes</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['pending_projects'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Empreendedores Pendentes</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['pending_entrepreneurs'] }}</p>
            </div>
        @endhasanyrole

        @role('operador')
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Ações</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['actions'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Eventos</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['events'] }}</p>
            </div>
        @endrole

        @role('estudante')
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Projetos Integradores</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['projects'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Empreendedores</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['entrepreneurs'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Áreas</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['areas'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Projetos Pendentes</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['pending_projects'] }}</p>
            </div>
            <div class="totem-card p-6">
                <p class="text-sm text-slate-500">Empreendedores Pendentes</p>
                <p class="mt-2 text-3xl font-display text-slate-900">{{ $stats['pending_entrepreneurs'] }}</p>
            </div>
        @endrole
    </div>

    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="totem-card p-6">
            <h3 class="font-display text-xl text-slate-900">Atalhos</h3>
            <div class="mt-4 flex flex-wrap gap-3">
                @hasanyrole('super_admin|admin_unidade|operador')
                    <a href="{{ route('admin.actions.create') }}" class="px-4 py-2 rounded-full bg-senac-orange text-white font-semibold">Nova Acao</a>
                    <a href="{{ route('admin.events.create') }}" class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Novo Evento</a>
                @endhasanyrole
                @hasanyrole('super_admin|admin_unidade|estudante')
                    <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Novo Projeto</a>
                    <a href="{{ route('admin.entrepreneurs.create') }}" class="px-4 py-2 rounded-full bg-slate-700 text-white font-semibold">Novo Empreendedor</a>
                @endhasanyrole
                @hasanyrole('super_admin|admin_unidade')
                    <a href="{{ route('admin.approvals.index') }}" class="px-4 py-2 rounded-full bg-emerald-600 text-white font-semibold">Aprovar Pendentes</a>
                    <a href="{{ route('admin.areas.index') }}" class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Gerenciar Áreas</a>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Gerenciar Usuarios</a>
                @endhasanyrole
                @role('super_admin')
                    <a href="{{ route('admin.unidades.index') }}" class="px-4 py-2 rounded-full bg-senac-orange text-white font-semibold">Gerenciar Unidades</a>
                @endrole
            </div>
        </div>

        @role('estudante')
            <div class="totem-card p-6">
                <h3 class="font-display text-xl text-slate-900">Seu painel</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Cadastre seu perfil empreendedor e seu projeto integrador. Para adicionar integrantes,
                    eles precisam ter conta cadastrada no sistema.
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('admin.entrepreneurs.create') }}" class="px-4 py-2 rounded-full bg-slate-700 text-white font-semibold">Meu Empreendimento</a>
                    <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Novo Projeto</a>
                </div>
            </div>
        @endrole
    </div>
@endsection
