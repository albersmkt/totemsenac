@extends('layouts.totem')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="font-display text-3xl text-slate-900">{{ $action->title }}</h2>
        <a href="{{ route('totem.actions.index') }}" class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Voltar</a>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <div class="totem-card">
            <div class="h-72 bg-slate-100">
                @if ($action->cover_image)
                    <img src="{{ asset('storage/' . $action->cover_image) }}" alt="{{ $action->title }}" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-gradient-to-br from-senac-orange/20 to-senac-blue/20"></div>
                @endif
            </div>
            <div class="p-6 space-y-4">
                <div class="flex flex-wrap gap-4 text-sm text-slate-600">
                    <span class="px-3 py-1 rounded-full bg-senac-sand text-slate-700 font-semibold">
                        {{ $action->start_at->format('d/m/Y H:i') }}
                    </span>
                    @if ($action->end_at)
                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">
                            Ate {{ $action->end_at->format('d/m/Y H:i') }}
                        </span>
                    @endif
                    @if ($action->location)
                        <span class="px-3 py-1 rounded-full bg-senac-sky text-slate-700 font-semibold">
                            {{ $action->location }}
                        </span>
                    @endif
                </div>
                <p class="text-lg text-slate-700 leading-relaxed">{{ $action->description }}</p>
            </div>
        </div>
    </div>
@endsection
