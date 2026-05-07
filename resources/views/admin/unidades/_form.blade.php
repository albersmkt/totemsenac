@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Nome da unidade</label>
        <input
            name="nome"
            value="{{ old('nome', $unidade->nome ?? '') }}"
            required
            maxlength="150"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="Ex.: Senac Sorocaba"
        >
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Cidade</label>
        <input
            name="cidade"
            value="{{ old('cidade', $unidade->cidade ?? '') }}"
            required
            maxlength="120"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="Ex.: Sorocaba"
        >
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.unidades.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
