<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;

class HomeController extends Controller
{
    public function index()
    {
        $actions = Action::where('status', 'published')
            ->orderByDesc('start_at')
            ->limit(8)
            ->get();

        $events = Event::where('status', 'published')
            ->orderByDesc('start_at')
            ->limit(8)
            ->get();

        $projects = IntegratorProject::with('area')
            ->where('status', 'published')
            ->latest()
            ->limit(8)
            ->get();

        $entrepreneurs = Entrepreneur::where('status', 'approved')
            ->with('images')
            ->latest()
            ->limit(8)
            ->get();

        $heroSlides = collect();

        $heroAction = Action::where('status', 'published')
            ->orderByDesc('start_at')
            ->first();
        if ($heroAction) {
            $heroSlides->push([
                'label' => 'Acao',
                'title' => $heroAction->title,
                'description' => $heroAction->description,
                'image' => $heroAction->cover_image,
                'link' => route('totem.actions.show', $heroAction),
            ]);
        }

        $heroEvent = Event::where('status', 'published')
            ->orderByDesc('start_at')
            ->first();
        if ($heroEvent) {
            $heroSlides->push([
                'label' => 'Evento',
                'title' => $heroEvent->title,
                'description' => $heroEvent->description,
                'image' => $heroEvent->cover_image,
                'link' => route('totem.events.show', $heroEvent),
            ]);
        }

        $heroProject = IntegratorProject::where('status', 'published')
            ->latest()
            ->first();
        if ($heroProject) {
            $heroSlides->push([
                'label' => 'Projeto Integrador',
                'title' => $heroProject->title,
                'description' => $heroProject->description,
                'image' => $heroProject->cover_image,
                'link' => route('totem.projects.show', $heroProject),
            ]);
        }

        $heroEntrepreneur = Entrepreneur::where('status', 'approved')
            ->with('images')
            ->latest()
            ->first();
        if ($heroEntrepreneur) {
            $heroSlides->push([
                'label' => 'Empreendedor',
                'title' => $heroEntrepreneur->display_name,
                'description' => $heroEntrepreneur->description ?? 'Conheca negocios locais e criativos.',
                'image' => $heroEntrepreneur->images->first()?->path,
                'link' => route('totem.entrepreneurs.show', $heroEntrepreneur),
            ]);
        }

        return view('totem.home', compact('actions', 'events', 'projects', 'entrepreneurs', 'heroSlides'));
    }
}
