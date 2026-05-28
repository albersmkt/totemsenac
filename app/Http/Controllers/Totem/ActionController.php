<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Support\UnitContext;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        $actions = Action::visibleOnTotem()
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->paginate(12)
            ->withQueryString();

        return view('totem.actions.index', compact('actions'));
    }

    public function show(Request $request, Action $action)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        abort_unless($action->isVisibleOnTotem() && (int) $action->unidade_id === (int) $unitId, 404);

        return view('totem.actions.show', compact('action'));
    }
}
