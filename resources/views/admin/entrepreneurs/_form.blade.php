@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Nome/Negocio</label>
        <input name="display_name" value="{{ old('display_name', $entrepreneur->display_name ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Categoria</label>
        <select name="category" class="mt-1 w-full rounded-xl border-slate-200">
            @foreach (['sobremesa' => 'Sobremesa', 'salgado' => 'Salgado', 'salgados_doces' => 'Salgados/Doces', 'servicos' => 'Servicos'] as $value => $label)
                <option value="{{ $value }}" @selected(old('category', $entrepreneur->category ?? 'sobremesa') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Descricao</label>
        <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-slate-200">{{ old('description', $entrepreneur->description ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-semibold text-slate-700">WhatsApp</label>
            <input name="whatsapp_number" value="{{ old('whatsapp_number', $entrepreneur->whatsapp_number ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Mensagem</label>
            <input name="whatsapp_message_template" value="{{ old('whatsapp_message_template', $entrepreneur->whatsapp_message_template ?? 'Ola! Vi seu perfil no Totem Senac Registro e gostaria de saber mais.') }}" class="mt-1 w-full rounded-xl border-slate-200">
        </div>
    </div>
    @hasanyrole('super_admin|admin_unidade')
        <div>
            <label class="text-sm font-semibold text-slate-700">Status</label>
            <select name="status" class="mt-1 w-full rounded-xl border-slate-200">
                @foreach (['pending' => 'Pendente', 'approved' => 'Aprovado', 'rejected' => 'Reprovado'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $entrepreneur->status ?? 'pending') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endhasanyrole
    <div>
        <label class="text-sm font-semibold text-slate-700">Fotos</label>
        <input type="file" name="photos[]" accept="image/*" multiple class="mt-1 w-full rounded-xl border-slate-200">
        <p class="mt-1 text-xs text-slate-500">JPG, PNG ou WEBP. Ate 8MB cada.</p>
        @if (!empty($entrepreneur) && $entrepreneur->images->count())
            <div class="mt-3 grid grid-cols-3 gap-3">
                @foreach ($entrepreneur->images as $image)
                    <label class="text-xs text-slate-500">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Foto" class="h-20 w-full object-cover rounded-lg mb-2">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Remover
                    </label>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-slate-700 text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.entrepreneurs.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
