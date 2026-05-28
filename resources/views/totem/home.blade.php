@extends('layouts.totem')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    @if (! $showUnits)
        <section class="hero mb-12" data-hero>
            <div class="hero-slides">
                @forelse ($heroSlides as $index => $slide)
                    @php
                        $bg = $slide['image'] ? asset('storage/' . $slide['image']) : null;
                    @endphp
                    <div
                        class="hero-slide {{ $index === 0 ? 'is-active' : '' }}"
                        data-hero-slide
                        @if ($bg)
                            style="background-image: url('{{ $bg }}');"
                        @endif
                    >
                        <div class="hero-overlay"></div>
                        <div class="hero-content">
                            <span class="hero-badge">{{ $slide['label'] }}</span>
                            <h2 class="hero-title">{{ $slide['title'] }}</h2>
                            <p class="hero-description">{{ Str::limit($slide['description'], 140) }}</p>
                            <a href="{{ $slide['link'] }}" class="hero-cta">Saiba Mais</a>
                        </div>
                    </div>
                @empty
                    <div class="hero-slide is-active">
                        <div class="hero-overlay"></div>
                        <div class="hero-content">
                            <span class="hero-badge">Senac Registro</span>
                            <h2 class="hero-title">Totem Digital</h2>
                            <p class="hero-description">Explore ações, eventos e projetos criativos do Senac.</p>
                            <a href="{{ route('totem.actions.index', $totemRouteParams) }}" class="hero-cta">Saiba Mais</a>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" class="hero-nav hero-prev" data-hero-prev>&larr;</button>
            <button type="button" class="hero-nav hero-next" data-hero-next>&rarr;</button>
            <div class="hero-dots">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button" class="hero-dot {{ $index === 0 ? 'is-active' : '' }}" data-hero-dot data-hero-index="{{ $index }}"></button>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mb-12">
        <div class="text-center mb-8">
            <h2 class="font-display text-3xl text-senac-blue mb-4">O que é o Totem Digital?</h2>
            <p class="text-lg text-slate-600 max-w-3xl mx-auto">
                O Totem Digital do Senac é uma plataforma interativa que conecta estudantes, empreendedores e comunidade local.
                Explore ações formativas, eventos culturais, projetos inovadores e negócios criativos de nossas unidades.
                Toque nas telas para descobrir oportunidades de aprendizado, empreendedorismo e cultura.
            </p>
        </div>
    </section>

    @if($showUnits)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Nossas Unidades</p>
                    <h2 class="font-display text-3xl text-senac-blue">Conheça nossas unidades</h2>
                </div>
            </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($unidades as $unidade)
                <div class="totem-card">
                    <div class="h-48 bg-slate-100 rounded-t-lg overflow-hidden">
                        @if ($unidade->image)
                            <img src="{{ asset('storage/' . $unidade->image) }}" alt="{{ $unidade->nome }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="h-16 w-16 text-senac-blue/50 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p class="text-sm text-senac-blue/70 font-medium">{{ $unidade->nome }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-slate-900 mb-2">{{ $unidade->nome }}</h3>
                        <p class="text-sm text-slate-600 mb-4">{{ $unidade->cidade }}</p>
                        <a href="{{ route('totem.home', ['unidade' => $unidade->id]) }}" class="inline-flex items-center text-sm font-semibold text-senac-blue hover:text-senac-blue/80">
                            Explorar unidade
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-slate-500">Nenhuma unidade cadastrada.</div>
            @endforelse
        </div>
    </section>
    @endif

    @if(!$showUnits)
    <section class="mb-12" data-carousel>
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Programação</p>
                <h2 class="font-display text-3xl text-senac-blue">Ações</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="carousel-nav" data-carousel-prev>&larr;</button>
                <button type="button" class="carousel-nav" data-carousel-next>&rarr;</button>
                <a href="{{ route('totem.actions.index', $totemRouteParams) }}" class="ml-2 text-sm font-semibold text-senac-blue">Ver todas</a>
            </div>
        </div>
        <div class="carousel-track" data-carousel-track>
            @forelse ($actions as $action)
                <a href="{{ route('totem.actions.show', ['action' => $action] + $totemRouteParams) }}" class="totem-card carousel-card">
                    <div class="h-40 bg-slate-100">
                        @if ($action->cover_image)
                            <img src="{{ asset('storage/' . $action->cover_image) }}" alt="{{ $action->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-400">{{ $action->start_at->format('d/m/Y') }}</p>
                        <h3 class="mt-2 font-semibold text-slate-900">{{ $action->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ Str::limit($action->description, 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhuma ação publicada ainda.</div>
            @endforelse
        </div>
    </section>

    <section class="mb-12" data-carousel>
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Agenda</p>
                <h2 class="font-display text-3xl text-senac-blue">Eventos</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="carousel-nav" data-carousel-prev>&larr;</button>
                <button type="button" class="carousel-nav" data-carousel-next>&rarr;</button>
                <a href="{{ route('totem.events.index', $totemRouteParams) }}" class="ml-2 text-sm font-semibold text-senac-blue">Ver todos</a>
            </div>
        </div>
        <div class="carousel-track" data-carousel-track>
            @forelse ($events as $event)
                <a href="{{ route('totem.events.show', ['event' => $event] + $totemRouteParams) }}" class="totem-card carousel-card">
                    <div class="h-40 bg-slate-100">
                        @if ($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-400">{{ $event->start_at->format('d/m/Y') }}</p>
                        <h3 class="mt-2 font-semibold text-slate-900">{{ $event->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ Str::limit($event->description, 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhum evento publicado ainda.</div>
            @endforelse
        </div>
    </section>

    <section class="mb-12" data-carousel>
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Criação</p>
                <h2 class="font-display text-3xl text-senac-blue">Projeto Integrador</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="carousel-nav" data-carousel-prev>&larr;</button>
                <button type="button" class="carousel-nav" data-carousel-next>&rarr;</button>
                <a href="{{ route('totem.projects.index', $totemRouteParams) }}" class="ml-2 text-sm font-semibold text-senac-blue">Ver todos</a>
            </div>
        </div>
        <div class="carousel-track" data-carousel-track>
            @forelse ($projects as $project)
                <a href="{{ route('totem.projects.show', ['project' => $project] + $totemRouteParams) }}" class="totem-card carousel-card">
                    <div class="h-40 bg-slate-100">
                        @if ($project->cover_image)
                            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-400">{{ $project->area?->name ?? $project->course }}</p>
                        <h3 class="mt-2 font-semibold text-slate-900">{{ $project->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ Str::limit($project->description, 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhum projeto publicado ainda.</div>
            @endforelse
        </div>
    </section>

    <section data-carousel>
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Negócios</p>
                <h2 class="font-display text-3xl text-senac-blue">Empreendedores</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="carousel-nav" data-carousel-prev>&larr;</button>
                <button type="button" class="carousel-nav" data-carousel-next>&rarr;</button>
                <a href="{{ route('totem.entrepreneurs.index', $totemRouteParams) }}" class="ml-2 text-sm font-semibold text-senac-blue">Ver todos</a>
            </div>
        </div>
        <div class="carousel-track" data-carousel-track>
            @forelse ($entrepreneurs as $entrepreneur)
                <a href="{{ route('totem.entrepreneurs.show', ['entrepreneur' => $entrepreneur] + $totemRouteParams) }}" class="totem-card carousel-card">
                    <div class="h-40 bg-slate-100">
                        @if ($entrepreneur->images->first())
                            <img src="{{ asset('storage/' . $entrepreneur->images->first()->path) }}" alt="{{ $entrepreneur->display_name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs uppercase tracking-widest text-slate-400">
                            {{ $entrepreneur->category === 'salgados_doces' ? 'Salgados/Doces' : ucfirst($entrepreneur->category) }}
                        </p>
                        <h3 class="mt-2 font-semibold text-slate-900">{{ $entrepreneur->display_name }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ Str::limit($entrepreneur->description ?? '', 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="text-slate-500">Nenhum empreendedor aprovado ainda.</div>
            @endforelse
        </div>
    </section>
    @endif
@endsection
