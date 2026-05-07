@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar Acao</h2>
    <form method="POST" action="{{ route('admin.actions.update', $action) }}" enctype="multipart/form-data" class="totem-card p-6">
        @method('PUT')
        @include('admin.actions._form')
    </form>
@endsection
