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

    @role('super_admin')
        @php
            $registrationLinks = [
                [
                    'label' => 'Cadastro de operador',
                    'description' => 'Envie este link para responsáveis que irão cadastrar operadores da unidade.',
                    'url' => route('register.operator'),
                ],
                [
                    'label' => 'Cadastro de admin da unidade',
                    'description' => 'Envie este link para responsáveis pela administração de uma unidade.',
                    'url' => route('register.unit-admin'),
                ],
            ];
        @endphp

        <div class="mt-10 totem-card p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="font-display text-xl text-slate-900">Links de cadastro</h3>
                    <p class="mt-2 text-sm text-slate-600">
                        Copie e encaminhe os links para liberar o cadastro de operadores e admins de unidade.
                    </p>
                </div>
                <span class="self-start rounded-full bg-senac-orange/10 px-3 py-1 text-xs font-semibold text-senac-orange">
                    Super admin
                </span>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach ($registrationLinks as $link)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-semibold text-slate-900">{{ $link['label'] }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $link['description'] }}</p>
                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <input
                                type="text"
                                readonly
                                value="{{ $link['url'] }}"
                                class="w-full rounded-xl border-slate-200 bg-white text-sm text-slate-700"
                                aria-label="{{ $link['label'] }}"
                                onclick="this.select()"
                            >
                            <button
                                type="button"
                                x-data="{ copied: false }"
                                x-on:click="navigator.clipboard.writeText(@js($link['url'])); copied = true; setTimeout(() => copied = false, 1800)"
                                class="inline-flex shrink-0 items-center justify-center rounded-full bg-senac-blue px-4 py-2 text-sm font-semibold text-white hover:bg-senac-blue/90"
                            >
                                <span x-show="! copied">Copiar</span>
                                <span x-cloak x-show="copied">Copiado</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endrole

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
                @hasanyrole('operador|estudante')
                    <a href="{{ route('admin.tutorial.index') }}" class="px-4 py-2 rounded-full bg-emerald-600 text-white font-semibold">Tutorial</a>
                @endhasanyrole
                @role('super_admin')
                    <a href="{{ route('admin.unidades.index') }}" class="px-4 py-2 rounded-full bg-senac-orange text-white font-semibold">Gerenciar Unidades</a>
                    <a href="{{ route('admin.tutorial-videos.index') }}" class="px-4 py-2 rounded-full bg-senac-blue text-white font-semibold">Gerenciar Tutoriais</a>
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
