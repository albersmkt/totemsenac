<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Support\UnitContext;

class ActionController extends Controller
{
    public function index()
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        $actions = Action::where('status', 'published')
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->paginate(12);

        return view('totem.actions.index', compact('actions'));
    }

    public function show(Action $action)
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        abort_unless($action->status === 'published' && (int) $action->unidade_id === (int) $unitId, 404);

        return view('totem.actions.show', compact('action'));
    }
}
