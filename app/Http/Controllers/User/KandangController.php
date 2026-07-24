<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kandang;

class KandangController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::with('creator')->latest()->paginate(10);
        return view('user.kandang.index', compact('kandangs'));
    }

    public function show(Kandang $kandang)
    {
        $kandang->load(['ayams', 'creator']);
        return view('user.kandang.show', compact('kandang'));
    }
}