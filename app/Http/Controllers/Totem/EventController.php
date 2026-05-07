<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'published')
            ->orderByDesc('start_at')
            ->paginate(12);

        return view('totem.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        abort_unless($event->status === 'published', 404);

        $event->load('images');

        return view('totem.events.show', compact('event'));
    }
}
