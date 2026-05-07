<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\IntegratorProject;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = IntegratorProject::with('area')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('totem.projects.index', compact('projects'));
    }

    public function show(IntegratorProject $project)
    {
        abort_unless($project->status === 'published', 404);

        $project->load(['images', 'members', 'creator', 'area']);

        return view('totem.projects.show', compact('project'));
    }
}
