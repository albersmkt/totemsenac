<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Senac Registro</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Senac Registro</p>
                    <h1 class="font-display text-2xl text-slate-900">Painel Administrativo</h1>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="px-3 py-1 rounded-full bg-senac-orange text-white font-semibold">
                        {{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-700 font-semibold">Meu perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-full bg-slate-900 text-white font-semibold">Sair</button>
                    </form>
                </div>
            </div>
            <nav class="max-w-6xl mx-auto px-6 pb-4 flex flex-wrap gap-3 text-sm font-semibold text-slate-600">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Painel</a>
                @hasanyrole('super_admin|operador')
                    <a href="{{ route('admin.actions.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Ações</a>
                    <a href="{{ route('admin.events.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Eventos</a>
                @endhasanyrole
                @hasanyrole('super_admin|estudante')
                    <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Projetos Integradores</a>
                    <a href="{{ route('admin.entrepreneurs.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Empreendedores</a>
                @endhasanyrole
                @role('super_admin')
                    <a href="{{ route('admin.approvals.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Aprovações</a>
                    <a href="{{ route('admin.areas.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Áreas</a>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-full bg-white border border-slate-200 hover:border-senac-orange">Usuarios</a>
                @endrole
                <a href="{{ route('totem.home') }}" class="px-4 py-2 rounded-full bg-senac-blue text-white">Abrir Totem</a>
            </nav>
        </header>

        <main class="flex-1 max-w-6xl mx-auto w-full px-6 py-8">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-rose-700">
                    <p class="font-semibold mb-2">Corrija os erros abaixo:</p>
                    <ul class="list-disc pl-5 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
