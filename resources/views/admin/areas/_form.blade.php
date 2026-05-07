@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Nome da área</label>
        <input
            name="name"
            value="{{ old('name', $area->name ?? '') }}"
            required
            maxlength="150"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="Ex.: Tecnologia da Informação"
        >
        <p class="mt-1 text-xs text-slate-500">Use nomes curtos e padronizados para facilitar o filtro.</p>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.areas.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
