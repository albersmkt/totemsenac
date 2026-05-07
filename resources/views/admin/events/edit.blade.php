@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar Evento</h2>
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="totem-card p-6">
        @method('PUT')
        @include('admin.events._form')
    </form>
@endsection
