<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;
use App\Models\Unidade;
use App\Support\UnitContext;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $unitId = UnitContext::resolveTotemUnitId($request);

        $requestedUnit = $request->query('unidade');
        $showUnits = ! (is_numeric($requestedUnit) && (int) $requestedUnit === (int) $unitId);
        $totemRouteParams = $showUnits ? [] : ['unidade' => $unitId];

        $actions = Action::visibleOnTotem()
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->limit(8)
            ->get();

        $events = Event::visibleOnTotem()
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->limit(8)
            ->get();

        $projects = IntegratorProject::with('area')
            ->where('status', 'published')
            ->where('unidade_id', $unitId)
            ->latest()
            ->limit(8)
            ->get();

        $entrepreneurs = Entrepreneur::where('status', 'approved')
            ->where('unidade_id', $unitId)
            ->with('images')
            ->latest()
            ->limit(8)
            ->get();

        $heroSlides = collect();

        $heroAction = Action::visibleOnTotem()
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->first();
        if ($heroAction) {
            $heroSlides->push([
                'label' => 'Acao',
                'title' => $heroAction->title,
                'description' => $heroAction->description,
                'image' => $heroAction->cover_image,
                'link' => route('totem.actions.show', ['action' => $heroAction] + $totemRouteParams),
            ]);
        }

        $heroEvent = Event::visibleOnTotem()
            ->where('unidade_id', $unitId)
            ->orderByDesc('start_at')
            ->first();
        if ($heroEvent) {
            $heroSlides->push([
                'label' => 'Evento',
                'title' => $heroEvent->title,
                'description' => $heroEvent->description,
                'image' => $heroEvent->cover_image,
                'link' => route('totem.events.show', ['event' => $heroEvent] + $totemRouteParams),
            ]);
        }

        $heroProject = IntegratorProject::where('status', 'published')
            ->where('unidade_id', $unitId)
            ->latest()
            ->first();
        if ($heroProject) {
            $heroSlides->push([
                'label' => 'Projeto Integrador',
                'title' => $heroProject->title,
                'description' => $heroProject->description,
                'image' => $heroProject->cover_image,
                'link' => route('totem.projects.show', ['project' => $heroProject] + $totemRouteParams),
            ]);
        }

        $heroEntrepreneur = Entrepreneur::where('status', 'approved')
            ->where('unidade_id', $unitId)
            ->with('images')
            ->latest()
            ->first();
        if ($heroEntrepreneur) {
            $heroSlides->push([
                'label' => 'Empreendedor',
                'title' => $heroEntrepreneur->display_name,
                'description' => $heroEntrepreneur->description ?? 'Conheca negocios locais e criativos.',
                'image' => $heroEntrepreneur->images->first()?->path,
                'link' => route('totem.entrepreneurs.show', ['entrepreneur' => $heroEntrepreneur] + $totemRouteParams),
            ]);
        }

        $unidades = collect();
        if ($showUnits) {
            $unidades = Unidade::query()
                ->orderBy('nome')
                ->get();
        }

        return view('totem.home', compact('actions', 'events', 'projects', 'entrepreneurs', 'heroSlides', 'unidades', 'showUnits', 'totemRouteParams'));
    }
}
