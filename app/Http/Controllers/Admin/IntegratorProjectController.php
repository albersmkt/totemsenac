<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\IntegratorProject;
use App\Models\IntegratorProjectImage;
use App\Support\UnitContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IntegratorProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', IntegratorProject::class);

        $query = IntegratorProject::query()->with('area');
        UnitContext::applyAdminScope($query, $request->user(), $request);
        if ($request->user()->hasRole('estudante') && ! $request->user()->hasAnyRole(['super_admin', 'admin_unidade'])) {
            $query->where('created_by', $request->user()->id);
        }

        if ($request->filled('q')) {
            $search = (string) $request->string('q');
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('course', 'like', '%' . $search . '%')
                    ->orWhereHas('area', function ($areaQuery) use ($search) {
                        $areaQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $projects = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', IntegratorProject::class);

        $request = request();
        $creationUnitId = UnitContext::resolveCreationUnitId($request->user(), $request);
        $areas = Area::query()
            ->where('unidade_id', $creationUnitId)
            ->orderBy('name')
            ->get();

        return view('admin.projects.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', IntegratorProject::class);
        $creationUnitId = UnitContext::resolveCreationUnitId($request->user(), $request);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course' => 'required|string|max:255',
            'class_group' => 'required|string|max:255',
            'area_id' => [
                'required',
                Rule::exists('areas', 'id')->where(fn ($query) => $query->where('unidade_id', $creationUnitId)),
            ],
            'member_names' => 'nullable|string|max:2000',
            'status' => 'nullable|in:pending,rejected,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $data['created_by'] = $request->user()->id;
        $canManageStatus = $request->user()->hasAnyRole(['super_admin', 'admin_unidade']);
        $data['unidade_id'] = $creationUnitId;
        if (! $canManageStatus) {
            $data['status'] = 'pending';
        } else {
            $data['status'] = $data['status'] ?? 'pending';
        }

        $creatorName = $request->user()->name;
        if ($request->user()->hasRole('estudante') && ! $request->user()->hasAnyRole(['super_admin', 'admin_unidade'])) {
            $data['member_names'] = $this->normalizeMemberNames($request->input('member_names'), $creatorName);
        } elseif ($request->filled('member_names')) {
            $data['member_names'] = $this->normalizeMemberNames($request->input('member_names'), $creatorName);
        }

        $project = IntegratorProject::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                IntegratorProjectImage::create([
                    'integrator_project_id' => $project->id,
                    'path' => $image->store('projects/gallery', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('status', 'Projeto integrador criado.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IntegratorProject $project)
    {
        $this->authorize('update', $project);

        $project->load(['images', 'members', 'area']);
        $areaUnitId = $project->unidade_id ?: UnitContext::resolveCreationUnitId(request()->user(), request());
        $areas = Area::query()
            ->where('unidade_id', $areaUnitId)
            ->orderBy('name')
            ->get();

        return view('admin.projects.edit', compact('project', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IntegratorProject $project)
    {
        $this->authorize('update', $project);
        $targetUnitId = $project->unidade_id ?: UnitContext::resolveCreationUnitId($request->user(), $request);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course' => 'required|string|max:255',
            'class_group' => 'required|string|max:255',
            'area_id' => [
                'required',
                Rule::exists('areas', 'id')->where(fn ($query) => $query->where('unidade_id', $targetUnitId)),
            ],
            'member_names' => 'nullable|string|max:2000',
            'status' => 'nullable|in:pending,rejected,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'remove_cover' => 'nullable|boolean',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:integrator_project_images,id',
        ]);

        $canManageStatus = $request->user()->hasAnyRole(['super_admin', 'admin_unidade']);
        if (! $canManageStatus) {
            $data['status'] = $project->status;
        } else {
            $data['status'] = $data['status'] ?? $project->status;
        }

        $creatorName = $project->creator?->name ?? $request->user()->name;
        if ($request->user()->hasRole('estudante') && ! $request->user()->hasAnyRole(['super_admin', 'admin_unidade'])) {
            $data['member_names'] = $this->normalizeMemberNames($request->input('member_names'), $creatorName);
        } elseif ($request->filled('member_names')) {
            $data['member_names'] = $this->normalizeMemberNames($request->input('member_names'), $creatorName);
        }

        if ($request->boolean('remove_cover') && $project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        if (! empty($data['remove_images'])) {
            $images = $project->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        if ($request->hasFile('gallery')) {
            $currentCount = $project->images()->count();
            foreach ($request->file('gallery') as $index => $image) {
                IntegratorProjectImage::create([
                    'integrator_project_id' => $project->id,
                    'path' => $image->store('projects/gallery', 'public'),
                    'sort_order' => $currentCount + $index,
                ]);
            }
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Projeto integrador atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntegratorProject $project)
    {
        $this->authorize('delete', $project);

        if ($project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Projeto integrador removido.');
    }

    private function normalizeMemberNames(?string $raw, string $creatorName): string
    {
        $raw = (string) $raw;
        $raw = str_replace(["\r\n", "\r"], "\n", $raw);
        $parts = preg_split('/[\n,;]+/', $raw) ?: [];

        $names = [];
        foreach ($parts as $part) {
            $name = trim($part);
            if ($name !== '') {
                $names[] = $name;
            }
        }

        if ($creatorName !== '') {
            $names[] = $creatorName;
        }

        $unique = [];
        foreach ($names as $name) {
            $key = mb_strtolower($name);
            if (! array_key_exists($key, $unique)) {
                $unique[$key] = $name;
            }
        }

        return implode("\n", array_values($unique));
    }
}
