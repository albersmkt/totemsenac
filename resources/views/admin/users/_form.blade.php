@php
    $user = $user ?? null;
    $currentRole = $currentRole ?? null;
@endphp

@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Nome</label>
        <input name="name" value="{{ old('name', $user?->name) }}" required class="mt-1 w-full rounded-xl border-slate-200">
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user?->email) }}" required class="mt-1 w-full rounded-xl border-slate-200">
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Senha</label>
        <input type="password" name="password" class="mt-1 w-full rounded-xl border-slate-200">
        <p class="mt-1 text-xs text-slate-500">
            @if (!empty($user))
                Preencha apenas se desejar alterar a senha.
            @else
                Minimo de 8 caracteres.
            @endif
        </p>
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Nivel de acesso</label>
        @php
            $selectedRole = old('role', $currentRole ?? null);
        @endphp
        <select name="role" required class="mt-1 w-full rounded-xl border-slate-200">
            <option value="">Selecione</option>
            @foreach ($roles as $value => $label)
                <option value="{{ $value }}" @selected($selectedRole === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.users.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
