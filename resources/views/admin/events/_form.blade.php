@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Titulo</label>
        <input name="title" value="{{ old('title', $event->title ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Descricao</label>
        <textarea name="description" rows="5" required class="mt-1 w-full rounded-xl border-slate-200">{{ old('description', $event->description ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-semibold text-slate-700">Inicio</label>
            <input type="datetime-local" name="start_at" value="{{ old('start_at', isset($event) ? $event->start_at?->format('Y-m-d\\TH:i') : '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Fim</label>
            <input type="datetime-local" name="end_at" value="{{ old('end_at', isset($event) ? $event->end_at?->format('Y-m-d\\TH:i') : '') }}" class="mt-1 w-full rounded-xl border-slate-200">
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Local</label>
        <input name="location" value="{{ old('location', $event->location ?? '') }}" class="mt-1 w-full rounded-xl border-slate-200">
    </div>
    @hasanyrole('super_admin|admin_unidade')
        <div>
            <label class="text-sm font-semibold text-slate-700">Status</label>
            <select name="status" class="mt-1 w-full rounded-xl border-slate-200">
                @foreach (['pending' => 'Pendente', 'draft' => 'Rascunho', 'published' => 'Publicado', 'archived' => 'Arquivado'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $event->status ?? 'draft') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    @endhasanyrole
    <div>
        <label class="text-sm font-semibold text-slate-700">Capa</label>
        <input type="file" name="cover_image" accept="image/*" class="mt-1 w-full rounded-xl border-slate-200">
        <p class="mt-1 text-xs text-slate-500">JPG, PNG ou WEBP. Ate 8MB. Proporcao sugerida 16:9 (ex: 1280x720).</p>
        @if (!empty($event?->cover_image))
            <div class="mt-3 flex items-center gap-3">
                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Capa" class="h-20 w-28 object-cover rounded-lg">
                <label class="text-sm text-slate-600 flex items-center gap-2">
                    <input type="checkbox" name="remove_cover" value="1">
                    Remover capa
                </label>
            </div>
        @endif
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Galeria</label>
        <input type="file" name="gallery[]" accept="image/*" multiple class="mt-1 w-full rounded-xl border-slate-200">
        <p class="mt-1 text-xs text-slate-500">Selecione ate 10 imagens por envio. Ate 8MB cada.</p>
        @if (!empty($event) && $event->images->count())
            <div class="mt-3 grid grid-cols-3 gap-3">
                @foreach ($event->images as $image)
                    <label class="text-xs text-slate-500">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria" class="h-20 w-full object-cover rounded-lg mb-2">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Remover
                    </label>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-blue text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.events.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
