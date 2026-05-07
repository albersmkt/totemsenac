<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;
use App\Support\UnitContext;

class ApprovalController extends Controller
{
    public function index()
    {
        $request = request();
        $scope = fn ($query) => UnitContext::applyAdminScope($query, $request->user(), $request);

        $pendingActions = $scope(Action::with(['creator', 'unidade']))
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingEvents = $scope(Event::with(['creator', 'unidade']))
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingProjects = $scope(IntegratorProject::with(['creator', 'members', 'images', 'area', 'unidade']))
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingEntrepreneurs = $scope(Entrepreneur::with(['creator', 'unidade']))
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.approvals.index', compact('pendingActions', 'pendingEvents', 'pendingProjects', 'pendingEntrepreneurs'));
    }

    public function showAction(Action $action)
    {
        $this->assertUnitAccess((int) $action->unidade_id);
        $action->load(['creator', 'unidade']);

        return view('admin.approvals.show-action', compact('action'));
    }

    public function showEvent(Event $event)
    {
        $this->assertUnitAccess((int) $event->unidade_id);
        $event->load(['creator', 'images', 'unidade']);

        return view('admin.approvals.show-event', compact('event'));
    }

    public function showEntrepreneur(Entrepreneur $entrepreneur)
    {
        $this->assertUnitAccess((int) $entrepreneur->unidade_id);
        $entrepreneur->load(['creator', 'images', 'unidade']);

        return view('admin.approvals.show-entrepreneur', compact('entrepreneur'));
    }

    public function showProject(IntegratorProject $project)
    {
        $this->assertUnitAccess((int) $project->unidade_id);
        $project->load(['creator', 'members', 'images', 'area', 'unidade']);

        return view('admin.approvals.show', compact('project'));
    }

    public function approveEntrepreneur(Entrepreneur $entrepreneur)
    {
        $this->assertUnitAccess((int) $entrepreneur->unidade_id);
        $entrepreneur->update([
            'status' => 'approved',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Empreendedor aprovado.');
    }

    public function rejectEntrepreneur(Entrepreneur $entrepreneur)
    {
        $this->assertUnitAccess((int) $entrepreneur->unidade_id);
        $entrepreneur->update([
            'status' => 'rejected',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Empreendedor reprovado.');
    }

    public function approveProject(IntegratorProject $project)
    {
        $this->assertUnitAccess((int) $project->unidade_id);
        $project->update([
            'status' => 'published',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Projeto aprovado e publicado.');
    }

    public function rejectProject(IntegratorProject $project)
    {
        $this->assertUnitAccess((int) $project->unidade_id);
        $project->update([
            'status' => 'rejected',
            'approved_by' => request()->user()->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Projeto reprovado.');
    }

    public function approveAction(Action $action)
    {
        $this->assertUnitAccess((int) $action->unidade_id);
        $action->update([
            'status' => 'published',
            'published_at' => $action->published_at ?? now(),
        ]);

        return back()->with('status', 'Ação aprovada e publicada.');
    }

    public function rejectAction(Action $action)
    {
        $this->assertUnitAccess((int) $action->unidade_id);
        $action->update([
            'status' => 'archived',
            'published_at' => null,
        ]);

        return back()->with('status', 'Ação reprovada.');
    }

    public function approveEvent(Event $event)
    {
        $this->assertUnitAccess((int) $event->unidade_id);
        $event->update([
            'status' => 'published',
            'published_at' => $event->published_at ?? now(),
        ]);

        return back()->with('status', 'Evento aprovado e publicado.');
    }

    public function rejectEvent(Event $event)
    {
        $this->assertUnitAccess((int) $event->unidade_id);
        $event->update([
            'status' => 'archived',
            'published_at' => null,
        ]);

        return back()->with('status', 'Evento reprovado.');
    }

    private function assertUnitAccess(int $unitId): void
    {
        $user = request()->user();
        if ($user->hasRole('super_admin')) {
            return;
        }

        if ((int) $user->unidade_id !== $unitId) {
            abort(403);
        }
    }
}
