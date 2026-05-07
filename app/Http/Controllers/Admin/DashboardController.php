<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Area;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;

class DashboardController extends Controller
{
    public function index()
    {
        $user = request()->user();

        if ($user->hasRole('super_admin')) {
            $stats = [
                'actions' => Action::count(),
                'events' => Event::count(),
                'areas' => Area::count(),
                'projects' => IntegratorProject::count(),
                'entrepreneurs' => Entrepreneur::count(),
                'pending_projects' => IntegratorProject::where('status', 'pending')->count(),
                'pending_entrepreneurs' => Entrepreneur::where('status', 'pending')->count(),
            ];
        } elseif ($user->hasRole('operador')) {
            $stats = [
                'actions' => Action::where('created_by', $user->id)->count(),
                'events' => Event::where('created_by', $user->id)->count(),
                'projects' => 0,
                'areas' => Area::count(),
                'entrepreneurs' => 0,
                'pending_projects' => 0,
                'pending_entrepreneurs' => 0,
            ];
        } else {
            $stats = [
                'actions' => 0,
                'events' => 0,
                'projects' => IntegratorProject::where('created_by', $user->id)->count(),
                'areas' => Area::count(),
                'entrepreneurs' => Entrepreneur::where('created_by', $user->id)->count(),
                'pending_projects' => IntegratorProject::where('created_by', $user->id)
                    ->where('status', 'pending')
                    ->count(),
                'pending_entrepreneurs' => Entrepreneur::where('created_by', $user->id)
                    ->where('status', 'pending')
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact('stats'));
    }
}
