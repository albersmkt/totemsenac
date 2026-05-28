<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutorialVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TutorialVideoController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $role = $request->query('role');

        $videos = TutorialVideo::query()
            ->when($q !== '', fn ($query) => $query->where('title', 'like', "%{$q}%"))
            ->when(in_array($role, ['operador', 'estudante'], true), fn ($query) => $query->where('audience_role', $role))
            ->orderBy('audience_role')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('admin.tutorial-videos.index', compact('videos', 'q', 'role'));
    }

    public function create(): View
    {
        return view('admin.tutorial-videos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['youtube_video_id'] = $this->parseYoutubeVideoId($data['youtube_url']);
        $data['sort_order'] = $this->resolveSortOrder($data);
        $data['is_active'] = $request->boolean('is_active', true);

        TutorialVideo::create($data);

        return redirect()
            ->route('admin.tutorial-videos.index')
            ->with('status', 'Vídeo de tutorial criado com sucesso.');
    }

    public function edit(TutorialVideo $tutorialVideo): View
    {
        return view('admin.tutorial-videos.edit', compact('tutorialVideo'));
    }

    public function update(Request $request, TutorialVideo $tutorialVideo): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['youtube_video_id'] = $this->parseYoutubeVideoId($data['youtube_url']);
        $data['sort_order'] = $this->resolveSortOrder($data, $tutorialVideo);
        $data['is_active'] = $request->boolean('is_active');

        $tutorialVideo->update($data);

        return redirect()
            ->route('admin.tutorial-videos.index')
            ->with('status', 'Vídeo de tutorial atualizado com sucesso.');
    }

    public function destroy(TutorialVideo $tutorialVideo): RedirectResponse
    {
        $tutorialVideo->delete();

        return redirect()
            ->route('admin.tutorial-videos.index')
            ->with('status', 'Vídeo de tutorial removido com sucesso.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:2000'],
            'youtube_url' => ['required', 'url', 'max:500'],
            'audience_role' => ['required', Rule::in(['operador', 'estudante'])],
            'sort_order' => ['nullable', 'integer', 'min:1', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function resolveSortOrder(array $data, ?TutorialVideo $ignore = null): int
    {
        if (! empty($data['sort_order'])) {
            return (int) $data['sort_order'];
        }

        $lastPosition = TutorialVideo::query()
            ->where('audience_role', $data['audience_role'])
            ->when($ignore !== null, fn ($query) => $query->where('id', '!=', $ignore->id))
            ->max('sort_order');

        return ((int) $lastPosition) + 1;
    }

    private function parseYoutubeVideoId(string $url): string
    {
        $videoId = TutorialVideo::parseYoutubeVideoId($url);

        if ($videoId === null) {
            back()
                ->withErrors(['youtube_url' => 'Informe um link válido do YouTube.'])
                ->withInput()
                ->throwResponse();
        }

        return $videoId;
    }
}
