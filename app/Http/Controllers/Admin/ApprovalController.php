<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingActions = Action::with('creator')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingEvents = Event::with('creator')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingProjects = IntegratorProject::with(['creator', 'members', 'images', 'area'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingEntrepreneurs = Entrepreneur::with('creator')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.approvals.index', compact('pendingActions', 'pendingEvents', 'pendingProjects', 'pendingEntrepreneurs'));
    }

    public function showAction(Action $action)
    {
        $action->load('creator');

        return view('admin.approvals.show-action', compact('action'));
    }

    public function showEvent(Event $event)
    {
        $event->load(['creator', 'images']);

        return view('admin.approvals.show-event', compact('event'));
    }

    public function showEntrepreneur(Entrepreneur $entrepreneur)
    {
        $entrepreneur->load(['creator', 'images']);

        return view('admin.approvals.show-entrepreneur', compact('entrepreneur'));
    }

    public function showProject(IntegratorProject $project)
    {
        $project->load(['creator', 'members', 'images', 'area']);

        return view('admin.approvals.show', compact('project'));
    }

    public function approveEntrepreneur(Entrepreneur $entrepreneur)
    {
        $entrepreneur->update([
            'status' => 'approved',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Empreendedor aprovado.');
    }

    public function rejectEntrepreneur(Entrepreneur $entrepreneur)
    {
        $entrepreneur->update([
            'status' => 'rejected',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Empreendedor reprovado.');
    }

    public function approveProject(IntegratorProject $project)
    {
        $project->update([
            'status' => 'published',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Projeto aprovado e publicado.');
    }

    public function rejectProject(IntegratorProject $project)
    {
        $project->update([
            'status' => 'rejected',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Projeto reprovado.');
    }

    public function approveAction(Action $action)
    {
        $action->update([
            'status' => 'published',
            'published_at' => $action->published_at ?? now(),
        ]);

        return back()->with('status', 'Ação aprovada e publicada.');
    }

    public function rejectAction(Action $action)
    {
        $action->update([
            'status' => 'archived',
            'published_at' => null,
        ]);

        return back()->with('status', 'Ação reprovada.');
    }

    public function approveEvent(Event $event)
    {
        $event->update([
            'status' => 'published',
            'published_at' => $event->published_at ?? now(),
        ]);

        return back()->with('status', 'Evento aprovado e publicado.');
    }

    public function rejectEvent(Event $event)
    {
        $event->update([
            'status' => 'archived',
            'published_at' => null,
        ]);

        return back()->with('status', 'Evento reprovado.');
    }
}
