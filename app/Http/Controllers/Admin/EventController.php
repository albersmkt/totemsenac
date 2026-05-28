<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use App\Support\UnitContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Event::class);

        $query = Event::query();
        UnitContext::applyAdminScope($query, $request->user(), $request);
        if ($request->user()->hasRole('operador') && ! $request->user()->hasAnyRole(['super_admin', 'admin_unidade'])) {
            $query->where('created_by', $request->user()->id);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->string('q') . '%');
        }

        $events = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,draft,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
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

        $event = Event::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                EventImage::create([
                    'event_id' => $event->id,
                    'path' => $image->store('events/gallery', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('status', 'Evento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $event->load('images');

        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,draft,published,archived',
            'cover_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'remove_cover' => 'nullable|boolean',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|mimes:jpeg,jpg,png,gif,webp,bmp,svg|max:8192',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:event_images,id',
        ]);

        if ($request->boolean('remove_cover') && $event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        if (! empty($data['remove_images'])) {
            $images = $event->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        if ($request->hasFile('gallery')) {
            $currentCount = $event->images()->count();
            foreach ($request->file('gallery') as $index => $image) {
                EventImage::create([
                    'event_id' => $event->id,
                    'path' => $image->store('events/gallery', 'public'),
                    'sort_order' => $currentCount + $index,
                ]);
            }
        }

        $canManageStatus = $request->user()->hasAnyRole(['super_admin', 'admin_unidade']);
        if (! $canManageStatus) {
            $data['status'] = $event->status;
        } else {
            $data['status'] = $data['status'] ?? $event->status;
        }

        $data['published_at'] = $data['status'] === 'published' ? ($event->published_at ?? now()) : null;

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status', 'Evento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        foreach ($event->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Evento removido.');
    }
}
