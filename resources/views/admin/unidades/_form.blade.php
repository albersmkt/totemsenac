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

    <div>
        <label class="text-sm font-semibold text-slate-700">Imagem da unidade</label>
        <input
            type="file"
            name="image"
            accept="image/*"
            class="mt-1 w-full rounded-xl border-slate-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-senac-blue file:text-white hover:file:bg-senac-blue/90"
        >
        @if(isset($unidade) && $unidade->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $unidade->image) }}" alt="{{ $unidade->nome }}" class="h-20 w-20 object-cover rounded-lg">
            </div>
        @endif
        <p class="mt-1 text-xs text-slate-500">Formato: JPG, PNG, GIF. Tamanho máximo: 2MB</p>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.unidades.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
