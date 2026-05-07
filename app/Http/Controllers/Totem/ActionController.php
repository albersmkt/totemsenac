<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Action;

class ActionController extends Controller
{
    public function index()
    {
        $actions = Action::where('status', 'published')
            ->orderByDesc('start_at')
            ->paginate(12);

        return view('totem.actions.index', compact('actions'));
    }

    public function show(Action $action)
    {
        abort_unless($action->status === 'published', 404);

        return view('totem.actions.show', compact('action'));
    }
}
