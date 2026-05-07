<?php

namespace App\Http\Controllers\Totem;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BemestarController extends Controller
{
    public function index(): View
    {
        return view('totem.bemestar');
    }
}