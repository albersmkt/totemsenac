<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\UnitContext;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        $events = Event::where('status', 'published')
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->paginate(12)
            ->withQueryString();

        return view('totem.events.index', compact('events'));
    }

    public function show(Request $request, Event $event)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);
        abort_unless($event->status === 'published' && (int) $event->unidade_id === (int) $unitId, 404);

        $event->load('images');

        return view('totem.events.show', compact('event'));
    }
}
