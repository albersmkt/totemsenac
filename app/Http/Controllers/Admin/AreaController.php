<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Support\UnitContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $query = Area::query();
        UnitContext::applyAdminScope($query, $request->user(), $request);

        $areas = $query
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.areas.index', compact('areas', 'q'));
    }

    public function create(): View
    {
        return view('admin.areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $creationUnitId = UnitContext::resolveCreationUnitId($request->user(), $request);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('areas', 'name')->where(fn ($query) => $query->where('unidade_id', $creationUnitId)),
            ],
        ]);

        Area::create([
            'name' => $data['name'],
            'slug' => $this->buildSlug($data['name']),
            'unidade_id' => $creationUnitId,
        ]);

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área criada com sucesso.');
    }

    public function edit(Area $area): View
    {
        $this->assertAreaAccess($area, request());

        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $this->assertAreaAccess($area, $request);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('areas', 'name')
                    ->where(fn ($query) => $query->where('unidade_id', $area->unidade_id))
                    ->ignore($area->id),
            ],
        ]);

        $area->update([
            'name' => $data['name'],
            'slug' => $this->buildSlug($data['name'], $area),
        ]);

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área atualizada com sucesso.');
    }

    public function destroy(Area $area): RedirectResponse
    {
        $this->assertAreaAccess($area, request());

        $area->delete();

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área removida com sucesso.');
    }

    private function buildSlug(string $name, ?Area $ignore = null): string
    {
        $baseSlug = Str::slug($name);
        if ($baseSlug === '') {
            $baseSlug = 'area';
        }

        $unitId = $ignore?->unidade_id
            ?: UnitContext::resolveCreationUnitId(request()->user(), request());

        $slug = $baseSlug;
        $counter = 2;

        while (Area::query()
            ->when($ignore !== null, fn ($query) => $query->where('id', '!=', $ignore->id))
            ->where('unidade_id', $unitId)
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function assertAreaAccess(Area $area, Request $request): void
    {
        $user = $request->user();
        if ($user->hasRole('super_admin')) {
            return;
        }

        if ((int) $area->unidade_id !== (int) $user->unidade_id) {
            abort(403);
        }
    }
}
