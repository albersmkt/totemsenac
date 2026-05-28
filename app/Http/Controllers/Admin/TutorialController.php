<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutorialCompletion;
use App\Models\TutorialVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TutorialController extends Controller
{
    public function index(Request $request): View
    {
        $audienceRole = $this->resolveAudienceRole($request);
        $videos = $this->videosFor($audienceRole)->get();
        $completedIds = $this->completedIds($request, $videos->pluck('id')->all());
        $completedCount = count($completedIds);
        $totalCount = $videos->count();
        $progress = $totalCount > 0 ? (int) floor(($completedCount / $totalCount) * 100) : 0;
        $certificateAvailable = $totalCount > 0 && $completedCount === $totalCount;

        return view('admin.tutorial.index', compact(
            'audienceRole',
            'videos',
            'completedIds',
            'completedCount',
            'totalCount',
            'progress',
            'certificateAvailable'
        ));
    }

    public function complete(Request $request, TutorialVideo $tutorialVideo): RedirectResponse
    {
        $audienceRole = $this->resolveAudienceRole($request);

        abort_unless(
            $tutorialVideo->is_active && $tutorialVideo->audience_role === $audienceRole,
            403
        );

        TutorialCompletion::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'tutorial_video_id' => $tutorialVideo->id,
            ],
            ['completed_at' => now()]
        );

        return back()->with('status', 'Aula marcada como concluída.');
    }

    public function certificate(Request $request): View
    {
        $audienceRole = $this->resolveAudienceRole($request);
        $videos = $this->videosFor($audienceRole)->get();
        $completedIds = $this->completedIds($request, $videos->pluck('id')->all());

        abort_unless($videos->isNotEmpty() && count($completedIds) === $videos->count(), 403);

        $completedAt = TutorialCompletion::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('tutorial_video_id', $videos->pluck('id'))
            ->max('completed_at');

        return view('admin.tutorial.certificate', [
            'audienceRole' => $audienceRole,
            'videos' => $videos,
            'completedAt' => $completedAt ? date_create($completedAt) : now(),
        ]);
    }

    private function videosFor(string $audienceRole)
    {
        return TutorialVideo::query()
            ->where('audience_role', $audienceRole)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    private function completedIds(Request $request, array $videoIds): array
    {
        if ($videoIds === []) {
            return [];
        }

        return TutorialCompletion::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('tutorial_video_id', $videoIds)
            ->pluck('tutorial_video_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    private function resolveAudienceRole(Request $request): string
    {
        $user = $request->user();

        if ($user->hasRole('estudante')) {
            return 'estudante';
        }

        if ($user->hasRole('operador')) {
            return 'operador';
        }

        $role = $request->query('role');
        if ($user->hasRole('super_admin') && in_array($role, ['operador', 'estudante'], true)) {
            return $role;
        }

        return 'operador';
    }
}
