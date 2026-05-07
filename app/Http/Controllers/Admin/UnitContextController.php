<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Support\UnitContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UnitContextController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'unidade_id' => ['required', 'string'],
        ]);

        if ($data['unidade_id'] === 'all') {
            $request->session()->put(UnitContext::SESSION_KEY, 'all');

            return back()->with('status', 'Visualização alterada para todas as unidades.');
        }

        $unit = Unidade::query()->findOrFail((int) $data['unidade_id']);
        $request->session()->put(UnitContext::SESSION_KEY, $unit->id);

        return back()->with('status', 'Visualizando unidade: '.$unit->nome.'.');
    }
}
