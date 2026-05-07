@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Titulo</label>
        <input name="title" value="{{ old('title', $project->title ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700">Descricao</label>
        <textarea name="description" rows="5" required class="mt-1 w-full rounded-xl border-slate-200">{{ old('description', $project->description ?? '') }}</textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="text-sm font-semibold text-slate-700">Curso</label>
            <input name="course" value="{{ old('course', $project->course ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Turma</label>
            <input name="class_group" value="{{ old('class_group', $project->class_group ?? '') }}" required class="mt-1 w-full rounded-xl border-slate-200">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Área</label>
            <select name="area_id" required class="mt-1 w-full rounded-xl border-slate-200">
                <option value="">Selecione</option>
                @foreach (($areas ?? collect()) as $area)
                    <option value="{{ $area->id }}" @selected((string) old('area_id', $project->area_id ?? '') === (string) $area->id)>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @role('super_admin')
        <div>
            <label class="text-sm font-semibold text-slate-700">Status</label>
            <select name="status" class="mt-1 w-full rounded-xl border-slate-200">
            @foreach (['pending' => 'Pendente', 'rejected' => 'Reprovado', 'published' => 'Publicado', 'archived' => 'Arquivado'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $project->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
            </select>
        </div>
    @endrole

    <div>
        <label class="text-sm font-semibold text-slate-700">Capa</label>
        <input type="file" name="cover_image" accept="image/*" class="mt-1 w-full rounded-xl border-slate-200">
        <p class="mt-1 text-xs text-slate-500">JPG, PNG ou WEBP. Ate 8MB. Proporcao sugerida 16:9 (ex: 1280x720).</p>
        @if (!empty($project?->cover_image))
            <div class="mt-3 flex items-center gap-3">
                <img src="{{ asset('storage/' . $project->cover_image) }}" alt="Capa" class="h-20 w-28 object-cover rounded-lg">
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
        @if (!empty($project) && $project->images->count())
            <div class="mt-3 grid grid-cols-3 gap-3">
                @foreach ($project->images as $image)
                    <label class="text-xs text-slate-500">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Galeria" class="h-20 w-full object-cover rounded-lg mb-2">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Remover
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    <div class="totem-card p-4">
        <h3 class="font-semibold text-slate-900 mb-3">Integrantes</h3>
        <textarea name="member_names" rows="4" class="w-full rounded-xl border-slate-200" placeholder="Digite um nome por linha">{{ old('member_names', $project->member_names ?? '') }}</textarea>
        <p class="mt-3 text-xs text-slate-500">
            Informe os integrantes (um por linha). O criador do projeto sera incluido automaticamente.
        </p>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-slate-900 text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.projects.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
