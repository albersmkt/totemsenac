@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Editar Empreendedor</h2>
    <form method="POST" action="{{ route('admin.entrepreneurs.update', $entrepreneur) }}" enctype="multipart/form-data" class="totem-card p-6">
        @method('PUT')
        @include('admin.entrepreneurs._form')
    </form>
@endsection
