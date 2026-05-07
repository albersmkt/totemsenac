<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\UnitContext;

class EventController extends Controller
{
    public function index()
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        $events = Event::where('status', 'published')
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->paginate(12);

        return view('totem.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $unitId = UnitContext::resolveTotemUnitId(request());
        abort_unless($event->status === 'published' && (int) $event->unidade_id === (int) $unitId, 404);

        $event->load('images');

        return view('totem.events.show', compact('event'));
    }
}
