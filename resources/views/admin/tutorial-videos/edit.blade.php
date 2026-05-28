@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar vídeo de tutorial</h2>
    <form method="POST" action="{{ route('admin.tutorial-videos.update', $tutorialVideo) }}" class="totem-card p-6">
        @method('PUT')
        @include('admin.tutorial-videos._form')
    </form>
@endsection
