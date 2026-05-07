<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entrepreneur;
use App\Models\EntrepreneurImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntrepreneurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Entrepreneur::class);

        $query = Entrepreneur::query()->with('creator');

        if (! $request->user()->hasRole('super_admin')) {
            $query->where('created_by', $request->user()->id);
        }

        if ($request->filled('q')) {
            $query->where('display_name', 'like', '%' . $request->string('q') . '%');
        }

        $entrepreneurs = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('admin.entrepreneurs.index', compact('entrepreneurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Entrepreneur::class);

        $user = request()->user();
        if ($user->hasRole('estudante') && ! $user->hasRole('super_admin')) {
            $existing = Entrepreneur::where('created_by', $user->id)->first();
            if ($existing) {
                return redirect()->route('admin.entrepreneurs.edit', $existing)
                    ->with('status', 'Voce ja possui um perfil. Edite os dados abaixo.');
            }
        }

        return view('admin.entrepreneurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Entrepreneur::class);

        $user = $request->user();
        if ($user->hasRole('estudante') && ! $user->hasRole('super_admin')) {
            $existing = Entrepreneur::where('created_by', $user->id)->first();
            if ($existing) {
                return redirect()->route('admin.entrepreneurs.edit', $existing)
                    ->with('status', 'Voce ja possui um perfil. Edite os dados abaixo.');
            }
        }

        $data = $request->validate([
            'display_name' => 'required|string|max:255',
            'category' => 'required|in:sobremesa,salgado,salgados_doces,servicos',
            'description' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:30',
            'whatsapp_message_template' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,approved,rejected',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:8192',
        ]);

        $data['created_by'] = $request->user()->id;
        if (! $request->user()->hasRole('super_admin')) {
            $data['status'] = 'pending';
        } else {
            $data['status'] = $data['status'] ?? 'pending';
        }

        $entrepreneur = Entrepreneur::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $image) {
                EntrepreneurImage::create([
                    'entrepreneur_id' => $entrepreneur->id,
                    'path' => $image->store('entrepreneurs', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.entrepreneurs.index')->with('status', 'Empreendedor cadastrado.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrepreneur $entrepreneur)
    {
        $this->authorize('update', $entrepreneur);

        $entrepreneur->load('images');

        return view('admin.entrepreneurs.edit', compact('entrepreneur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrepreneur $entrepreneur)
    {
        $this->authorize('update', $entrepreneur);

        $data = $request->validate([
            'display_name' => 'required|string|max:255',
            'category' => 'required|in:sobremesa,salgado,salgados_doces,servicos',
            'description' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:30',
            'whatsapp_message_template' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,approved,rejected',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:8192',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:entrepreneur_images,id',
        ]);

        if (! $request->user()->hasRole('super_admin')) {
            $data['status'] = $entrepreneur->status;
        } else {
            $data['status'] = $data['status'] ?? $entrepreneur->status;
        }

        if (! empty($data['remove_images'])) {
            $images = $entrepreneur->images()->whereIn('id', $data['remove_images'])->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        if ($request->hasFile('photos')) {
            $currentCount = $entrepreneur->images()->count();
            foreach ($request->file('photos') as $index => $image) {
                EntrepreneurImage::create([
                    'entrepreneur_id' => $entrepreneur->id,
                    'path' => $image->store('entrepreneurs', 'public'),
                    'sort_order' => $currentCount + $index,
                ]);
            }
        }

        $entrepreneur->update($data);

        return redirect()->route('admin.entrepreneurs.index')->with('status', 'Empreendedor atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrepreneur $entrepreneur)
    {
        $this->authorize('delete', $entrepreneur);

        foreach ($entrepreneur->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $entrepreneur->delete();

        return redirect()->route('admin.entrepreneurs.index')->with('status', 'Empreendedor removido.');
    }
}
