@extends('layouts.totem')

@php
    $totemRouteParams = request()->query('unidade') ? ['unidade' => request()->query('unidade')] : [];
@endphp

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="font-display text-3xl text-slate-900">{{ $project->title }}</h2>
        <a href="{{ route('totem.projects.index', $totemRouteParams) }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="totem-card mb-8">
        <div class="h-72 bg-slate-100">
            @if ($project->cover_image)
                <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
            @endif
        </div>
        <div class="p-6 space-y-4">
            <div class="flex flex-wrap gap-4 text-sm text-slate-600">
                <span class="px-3 py-1 rounded-full bg-senac-sand text-slate-700 font-semibold">
                    {{ $project->course }}
                </span>
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">
                    {{ $project->area?->name ?? 'Área não informada' }}
                </span>
                <span class="px-3 py-1 rounded-full bg-senac-sky text-slate-700 font-semibold">
                    Turma {{ $project->class_group }}
                </span>
            </div>
            <p class="text-lg text-slate-700 leading-relaxed">{!! nl2br(e($project->description)) !!}</p>
        </div>
    </div>

    @php
        $textMembers = $project->memberNamesFromText();
    @endphp

    @if (count($textMembers))
        <div class="mb-8">
            <h3 class="font-display text-xl text-slate-900 mb-3">Integrantes</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($textMembers as $name)
                    <div class="totem-card p-4">
                        <p class="font-semibold text-slate-900">{{ $name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif ($project->members->count())
        <div class="mb-8">
            <h3 class="font-display text-xl text-slate-900 mb-3">Integrantes</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($project->members as $member)
                    <div class="totem-card p-4">
                        <p class="font-semibold text-slate-900">{{ $member->name }}</p>
                        @if ($member->pivot->role_in_project)
                            <p class="text-sm text-slate-500">{{ $member->pivot->role_in_project }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @elseif ($project->creator)
        <div class="mb-8">
            <h3 class="font-display text-xl text-slate-900 mb-3">Integrantes</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="totem-card p-4">
                    <p class="font-semibold text-slate-900">{{ $project->creator->name }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($project->images->count())
        <div class="grid grid-cols-2 gap-4">
            @foreach ($project->images as $image)
                <div class="totem-card">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria {{ $project->title }}" class="w-full h-48 object-cover">
                </div>
            @endforeach
        </div>
    @endif
@endsection
