@csrf

<div class="grid gap-4">
    <div>
        <label class="text-sm font-semibold text-slate-700">Título do vídeo</label>
        <input
            name="title"
            value="{{ old('title', $tutorialVideo->title ?? '') }}"
            required
            maxlength="180"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="Ex.: Como cadastrar uma ação"
        >
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Descrição</label>
        <textarea
            name="description"
            rows="4"
            maxlength="2000"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="Resumo do que será aprendido neste vídeo"
        >{{ old('description', $tutorialVideo->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-sm font-semibold text-slate-700">Link do YouTube</label>
        <input
            type="url"
            name="youtube_url"
            value="{{ old('youtube_url', $tutorialVideo->youtube_url ?? '') }}"
            required
            maxlength="500"
            class="mt-1 w-full rounded-xl border-slate-200"
            placeholder="https://www.youtube.com/watch?v=..."
        >
        <p class="mt-1 text-xs text-slate-500">Aceita links do YouTube, YouTube Shorts, embed ou youtu.be.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-semibold text-slate-700">Público</label>
            <select name="audience_role" required class="mt-1 w-full rounded-xl border-slate-200">
                @foreach (['operador' => 'Operador', 'estudante' => 'Aluno'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('audience_role', $tutorialVideo->audience_role ?? 'operador') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold text-slate-700">Posição na trilha</label>
            <input
                type="number"
                name="sort_order"
                value="{{ old('sort_order', $tutorialVideo->sort_order ?? '') }}"
                min="1"
                max="9999"
                class="mt-1 w-full rounded-xl border-slate-200"
                placeholder="Ex.: 1"
            >
            <p class="mt-1 text-xs text-slate-500">Use 1 para a primeira aula, 2 para a segunda. Se deixar em branco, o vídeo entra no final.</p>
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tutorialVideo->is_active ?? true)) class="rounded border-slate-300 text-senac-blue">
        Ativo para os usuários
    </label>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold">Salvar</button>
    <a href="{{ route('admin.tutorial-videos.index') }}" class="px-5 py-2 rounded-full border border-slate-200 text-slate-600 font-semibold">Cancelar</a>
</div>
