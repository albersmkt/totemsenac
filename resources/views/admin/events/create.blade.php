@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Novo Evento</h2>
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="totem-card p-6">
        @include('admin.events._form')
    </form>
@endsection
