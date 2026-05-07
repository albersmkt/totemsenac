@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar Projeto Integrador</h2>
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="totem-card p-6">
        @method('PUT')
        @include('admin.projects._form')
    </form>
@endsection
