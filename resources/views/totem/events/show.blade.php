@extends('layouts.totem')

@php
    $totemRouteParams = request()->query('unidade') ? ['unidade' => request()->query('unidade')] : [];
@endphp

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="font-display text-3xl text-slate-900">{{ $event->title }}</h2>
        <a href="{{ route('totem.events.index', $totemRouteParams) }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="totem-card mb-8">
        <div class="h-72 bg-slate-100">
            @if ($event->cover_image)
                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full bg-gradient-to-br from-senac-blue/20 to-senac-orange/20"></div>
            @endif
        </div>
        <div class="p-6 space-y-4">
            <div class="flex flex-wrap gap-4 text-sm text-slate-600">
                <span class="px-3 py-1 rounded-full bg-senac-sand text-slate-700 font-semibold">
                    {{ $event->start_at->format('d/m/Y H:i') }}
                </span>
                @if ($event->end_at)
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">
                        Ate {{ $event->end_at->format('d/m/Y H:i') }}
                    </span>
                @endif
                @if ($event->location)
                    <span class="px-3 py-1 rounded-full bg-senac-sky text-slate-700 font-semibold">
                        {{ $event->location }}
                    </span>
                @endif
            </div>
            <p class="text-lg text-slate-700 leading-relaxed">{!! nl2br(e($event->description)) !!}</p>
        </div>
    </div>

    @if ($event->images->count())
        <div class="grid grid-cols-2 gap-4">
            @foreach ($event->images as $image)
                <div class="totem-card">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria {{ $event->title }}" class="w-full h-48 object-cover">
                </div>
            @endforeach
        </div>
    @endif
@endsection
