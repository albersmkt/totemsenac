@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Novo Empreendedor</h2>
    <form method="POST" action="{{ route('admin.entrepreneurs.store') }}" enctype="multipart/form-data" class="totem-card p-6">
        @include('admin.entrepreneurs._form')
    </form>
@endsection
