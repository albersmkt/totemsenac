<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Support\UnitContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Action::class);

        $query = Action::query();
        UnitContext::applyAdminScope($query, $request->user(), $request);
        if ($request->user()->hasRole('operador') && ! $request->user()->hasAnyRole(['super_admin', 'admin_unidade'])) {
            $query->where('created_by', $request->user()->id);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->string('q') . '%');
        }

        $actions = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('admin.actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Action::class);

        return view('admin.actions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Action::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,draft,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('actions', 'public');
        }

        $data['created_by'] = $request->user()->id;
        $canManageStatus = $request->user()->hasAnyRole(['super_admin', 'admin_unidade']);
        $data['unidade_id'] = UnitContext::resolveCreationUnitId($request->user(), $request);
        if (! $canManageStatus) {
            $data['status'] = 'pending';
        } else {
            $data['status'] = $data['status'] ?? 'draft';
        }
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        Action::create($data);

        return redirect()->route('admin.actions.index')->with('status', 'Acao criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Action $action)
    {
        $this->authorize('update', $action);

        return view('admin.actions.edit', compact('action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Action $action)
    {
        $this->authorize('update', $action);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,draft,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'remove_cover' => 'nullable|boolean',
        ]);

        if ($request->boolean('remove_cover') && $action->cover_image) {
            Storage::disk('public')->delete($action->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($action->cover_image) {
                Storage::disk('public')->delete($action->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('actions', 'public');
        }

        $canManageStatus = $request->user()->hasAnyRole(['super_admin', 'admin_unidade']);
        if (! $canManageStatus) {
            $data['status'] = $action->status;
        } else {
            $data['status'] = $data['status'] ?? $action->status;
        }

        $data['published_at'] = $data['status'] === 'published' ? ($action->published_at ?? now()) : null;

        $action->update($data);

        return redirect()->route('admin.actions.index')->with('status', 'Acao atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $this->authorize('delete', $action);

        if ($action->cover_image) {
            Storage::disk('public')->delete($action->cover_image);
        }

        $action->delete();

        return redirect()->route('admin.actions.index')->with('status', 'Acao removida.');
    }
}
