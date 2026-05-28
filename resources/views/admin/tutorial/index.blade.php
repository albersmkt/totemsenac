@extends('layouts.admin')

@section('content')
    @php
        $roleLabel = $audienceRole === 'operador' ? 'Operador' : 'Aluno';
    @endphp

    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tutorial {{ $roleLabel }}</p>
            <h2 class="mt-2 text-3xl font-display text-slate-900">Trilha de uso do sistema</h2>
            <p class="mt-2 text-sm text-slate-500">Assista às aulas, marque cada etapa como concluída e emita seu certificado ao final.</p>
        </div>
        @if ($certificateAvailable)
            <a
                href="{{ route('admin.tutorial.certificate', request()->only('role')) }}"
                class="font-semibold text-white hover:bg-emerald-700"
                style="display:inline-flex;align-items:center;justify-content:center;width:auto;height:42px;min-width:0;padding:0 28px;border-radius:9999px;background:#059669;font-size:14px;line-height:1;white-space:nowrap;flex:0 0 auto;"
            >
                Certificado
            </a>
        @endif
    </div>

    <div class="mb-8 grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6">
        <aside class="totem-card p-6 h-fit">
            <p class="text-sm text-slate-500">Progresso</p>
            <div class="mt-3 flex items-end gap-2">
                <span class="font-display text-4xl text-senac-blue">{{ $progress }}%</span>
                <span class="pb-1 text-sm text-slate-500">{{ $completedCount }}/{{ $totalCount }} aulas</span>
            </div>
            <div class="mt-4 h-3 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-senac-orange" style="width: {{ $progress }}%"></div>
            </div>
            <div class="mt-6 space-y-3">
                @forelse ($videos as $index => $video)
                    @php
                        $isCompleted = in_array($video->id, $completedIds, true);
                    @endphp
                    <a href="#aula-{{ $video->id }}" class="flex items-start gap-3 rounded-xl border border-slate-100 p-3 hover:border-senac-orange">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold {{ $isCompleted ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                            {{ $isCompleted ? '✓' : $index + 1 }}
                        </span>
                        <span>
                            <span class="block text-sm font-semibold text-slate-900">{{ $video->title }}</span>
                            <span class="text-xs text-slate-500">{{ $isCompleted ? 'Concluído' : 'Pendente' }}</span>
                        </span>
                    </a>
                @empty
                    <p class="text-sm text-slate-500">Nenhuma aula ativa para este perfil.</p>
                @endforelse
            </div>
        </aside>

        <div class="space-y-6">
            @forelse ($videos as $index => $video)
                @php
                    $isCompleted = in_array($video->id, $completedIds, true);
                @endphp
                <section id="aula-{{ $video->id }}" class="totem-card overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Aula {{ $index + 1 }}</p>
                                <h3 class="mt-1 font-display text-2xl text-slate-900">{{ $video->title }}</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isCompleted ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $isCompleted ? 'Concluída' : 'Pendente' }}
                            </span>
                        </div>

                        @if ($video->description)
                            <p class="mt-4 text-sm text-slate-600 leading-relaxed">{!! nl2br(e($video->description)) !!}</p>
                        @endif
                    </div>

                    <div class="aspect-video bg-slate-900">
                        <iframe
                            src="{{ $video->embedUrl() }}"
                            title="{{ $video->title }}"
                            class="h-full w-full border-0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>

                    <div class="p-6">
                        <div class="mt-6 flex flex-wrap gap-3">
                            @if ($isCompleted)
                                <button type="button" disabled class="px-5 py-2 rounded-full bg-emerald-50 text-emerald-700 font-semibold">Aula concluída</button>
                            @else
                                <form method="POST" action="{{ route('admin.tutorial.complete', ['tutorialVideo' => $video] + request()->only('role')) }}">
                                    @csrf
                                    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Marcar como concluída</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </section>
            @empty
                <div class="totem-card p-10 text-center">
                    <h3 class="font-display text-2xl text-slate-900">Tutorial em preparação</h3>
                    <p class="mt-2 text-slate-500">Ainda não há vídeos ativos para o perfil {{ strtolower($roleLabel) }}.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
