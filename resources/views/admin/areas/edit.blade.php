@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar área</h2>
    <form method="POST" action="{{ route('admin.areas.update', $area) }}" class="totem-card p-6">
        @method('PUT')
        @include('admin.areas._form')
    </form>
@endsection
