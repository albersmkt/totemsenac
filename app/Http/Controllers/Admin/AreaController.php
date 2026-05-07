<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
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

        $areas = Area::query()
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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:areas,name'],
        ]);

        Area::create([
            'name' => $data['name'],
            'slug' => $this->buildSlug($data['name']),
        ]);

        return redirect()
            ->route('admin.areas.index')
            ->with('status', 'Área criada com sucesso.');
    }

    public function edit(Area $area): View
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('areas', 'name')->ignore($area->id)],
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

        $slug = $baseSlug;
        $counter = 2;

        while (Area::query()
            ->when($ignore !== null, fn ($query) => $query->where('id', '!=', $ignore->id))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
