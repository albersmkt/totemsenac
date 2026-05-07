@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-display text-slate-900">Novo usuario</h2>
        <p class="mt-2 text-sm text-slate-500">Crie uma conta e defina o nivel de acesso.</p>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="totem-card p-6">
        @include('admin.users._form')
    </form>
@endsection
