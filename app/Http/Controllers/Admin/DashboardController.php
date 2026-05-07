<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Area;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;
use App\Support\UnitContext;

class DashboardController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $selectedUnitId = UnitContext::resolveAdminUnitId($user, request(), true);
        $scope = fn ($query) => $selectedUnitId === null
            ? $query
            : $query->where('unidade_id', $selectedUnitId);

        if ($user->hasRole('super_admin') || $user->hasRole('admin_unidade')) {
            $stats = [
                'actions' => $scope(Action::query())->count(),
                'events' => $scope(Event::query())->count(),
                'areas' => $scope(Area::query())->count(),
                'projects' => $scope(IntegratorProject::query())->count(),
                'entrepreneurs' => $scope(Entrepreneur::query())->count(),
                'pending_projects' => $scope(IntegratorProject::query()->where('status', 'pending'))->count(),
                'pending_entrepreneurs' => $scope(Entrepreneur::query()->where('status', 'pending'))->count(),
            ];
        } elseif ($user->hasRole('operador')) {
            $stats = [
                'actions' => Action::where('created_by', $user->id)->where('unidade_id', $user->unidade_id)->count(),
                'events' => Event::where('created_by', $user->id)->where('unidade_id', $user->unidade_id)->count(),
                'projects' => 0,
                'areas' => Area::where('unidade_id', $user->unidade_id)->count(),
                'entrepreneurs' => 0,
                'pending_projects' => 0,
                'pending_entrepreneurs' => 0,
            ];
        } else {
            $stats = [
                'actions' => 0,
                'events' => 0,
                'projects' => IntegratorProject::where('created_by', $user->id)->where('unidade_id', $user->unidade_id)->count(),
                'areas' => Area::where('unidade_id', $user->unidade_id)->count(),
                'entrepreneurs' => Entrepreneur::where('created_by', $user->id)->where('unidade_id', $user->unidade_id)->count(),
                'pending_projects' => IntegratorProject::where('created_by', $user->id)
                    ->where('unidade_id', $user->unidade_id)
                    ->where('status', 'pending')
                    ->count(),
                'pending_entrepreneurs' => Entrepreneur::where('created_by', $user->id)
                    ->where('unidade_id', $user->unidade_id)
                    ->where('status', 'pending')
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact('stats'));
    }
}
