<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Unidade;
use App\Support\UnitContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UnidadeController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $unidades = Unidade::query()
            ->withCount('users')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($builder) use ($q) {
                    $builder->where('nome', 'like', "%{$q}%")
                        ->orWhere('cidade', 'like', "%{$q}%");
                });
            })
            ->orderBy('nome')
            ->paginate(12)
            ->withQueryString();

        return view('admin.unidades.index', compact('unidades', 'q'));
    }

    public function create(): View
    {
        return view('admin.unidades.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:150', 'unique:unidades,nome'],
            'cidade' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,webp,bmp,svg', 'max:2048'],
        ]);

        $unidade = Unidade::create([
            'nome' => $data['nome'],
            'cidade' => $data['cidade'],
            'image' => $request->hasFile('image') ? $request->file('image')->store('unidades', 'public') : null,
        ]);

        $this->cloneDefaultAreasToUnit($unidade);

        return redirect()
            ->route('admin.unidades.index')
            ->with('status', 'Unidade criada com sucesso.');
    }

    public function edit(Unidade $unidade): View
    {
        return view('admin.unidades.edit', compact('unidade'));
    }

    public function update(Request $request, Unidade $unidade): RedirectResponse
    {
        $data = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:150',
                Rule::unique('unidades', 'nome')->ignore($unidade->id),
            ],
            'cidade' => ['required', 'string', 'max:120'],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,webp,bmp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($unidade->image) {
                Storage::disk('public')->delete($unidade->image);
            }

            $data['image'] = $request->file('image')->store('unidades', 'public');
        }

        $unidade->update($data);

        return redirect()
            ->route('admin.unidades.index')
            ->with('status', 'Unidade atualizada com sucesso.');
    }

    public function destroy(Unidade $unidade): RedirectResponse
    {
        $hasRelatedData = $unidade->users()->exists()
            || $unidade->actions()->exists()
            || $unidade->events()->exists()
            || $unidade->projects()->exists()
            || $unidade->entrepreneurs()->exists();

        if ($hasRelatedData) {
            return back()->withErrors([
                'unidade' => 'Nao e possivel excluir uma unidade com dados vinculados.',
            ]);
        }

        $unidade->areas()->delete();

        if ($unidade->image) {
            Storage::disk('public')->delete($unidade->image);
        }

        $unidade->delete();

        return redirect()
            ->route('admin.unidades.index')
            ->with('status', 'Unidade removida com sucesso.');
    }

    private function cloneDefaultAreasToUnit(Unidade $unidade): void
    {
        $defaultUnitId = UnitContext::defaultUnitId();
        if ($defaultUnitId === null) {
            return;
        }

        $areas = Area::query()
            ->where('unidade_id', $defaultUnitId)
            ->orderBy('name')
            ->get(['name']);

        foreach ($areas as $area) {
            $slugBase = Str::slug($area->name);
            $slug = $slugBase !== '' ? $slugBase : 'area';
            $suffix = 2;

            while (Area::query()
                ->where('unidade_id', $unidade->id)
                ->where('slug', $slug)
                ->exists()) {
                $slug = $slugBase.'-'.$suffix;
                $suffix++;
            }

            Area::create([
                'name' => $area->name,
                'slug' => $slug,
                'unidade_id' => $unidade->id,
            ]);
        }
    }
}
