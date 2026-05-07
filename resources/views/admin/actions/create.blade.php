@extends('layouts.admin')

@section('content')
    <h2 class="font-display text-2xl text-slate-900 mb-6">Nova Acao</h2>
    <form method="POST" action="{{ route('admin.actions.store') }}" enctype="multipart/form-data" class="totem-card p-6">
        @include('admin.actions._form')
    </form>
@endsection
