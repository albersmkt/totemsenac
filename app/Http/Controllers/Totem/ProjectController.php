<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\IntegratorProject;
use App\Support\UnitContext;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        $projects = IntegratorProject::with('area')
            ->where('status', 'published')
            ->where('unidade_id', $unitId)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('totem.projects.index', compact('projects'));
    }

    public function show(Request $request, IntegratorProject $project)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        abort_unless($project->status === 'published' && (int) $project->unidade_id === (int) $unitId, 404);

        $project->load(['images', 'members', 'creator', 'area']);

        return view('totem.projects.show', compact('project'));
    }
}
