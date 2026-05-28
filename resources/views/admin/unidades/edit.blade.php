@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar unidade</h2>
    <form method="POST" action="{{ route('admin.unidades.update', $unidade) }}" enctype="multipart/form-data" class="totem-card p-6">
        @method('PUT')
        @include('admin.unidades._form')
    </form>
@endsection
