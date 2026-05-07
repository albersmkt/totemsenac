@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Nova unidade</h2>
    <form method="POST" action="{{ route('admin.unidades.store') }}" class="totem-card p-6">
        @include('admin.unidades._form')
    </form>
@endsection
