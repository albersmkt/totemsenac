<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Senac Registro') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=space-grotesk:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen bg-slate-50">
            <div class="min-h-screen grid lg:grid-cols-[1.1fr_1fr]">
                <aside class="relative hidden lg:flex flex-col justify-between bg-senac-blue px-10 py-12 text-white overflow-hidden">
                    <div class="flex items-center gap-3">
                        <span class="text-xs uppercase tracking-[0.35em] text-white/70">Senac</span>
                        <span class="text-sm font-semibold">Registro</span>
                    </div>

                    <div class="max-w-md">
                        <p class="text-xs uppercase tracking-[0.3em] text-white/70">Totem Digital</p>
                        <h1 class="mt-4 font-display text-4xl leading-tight">{{ $sideTitle ?? 'Painel administrativo' }}</h1>
                        <p class="mt-4 text-white/80">
                            {{ $sideDescription ?? 'Gerencie ações, eventos, projetos integradores e empreendedores com identidade Senac.' }}
                        </p>
                    </div>

                    <div class="text-xs text-white/60">Acesso seguro e rapido</div>

                    <div class="absolute -right-24 -bottom-24 h-64 w-64 rounded-full bg-senac-orange/30 blur-3xl"></div>
                    <div class="absolute -left-24 top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
                </aside>

                <main class="flex items-center justify-center px-6 py-10 lg:px-12">
                    <div class="w-full max-w-md">
                        <div class="mb-8">
                            <span class="inline-flex items-center rounded-full bg-senac-orange/10 px-3 py-1 text-xs font-semibold text-senac-orange">
                                Senac Registro
                            </span>
                            <h2 class="mt-4 font-display text-3xl text-slate-900">{{ $pageTitle ?? 'Acesso ao sistema' }}</h2>
                            <p class="mt-2 text-sm text-slate-500">{{ $pageDescription ?? 'Area para equipe administrativa.' }}</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
