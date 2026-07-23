<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ayam;

class AyamController extends Controller
{
    public function index()
    {
        $ayams = Ayam::with(['kandang'])->latest()->paginate(10);
        return view('user.ayam.index', compact('ayams'));
    }

    public function show(Ayam $ayam)
    {
        $ayam->load(['kandang', 'kesehatanAyams']);
        return view('user.ayam.show', compact('ayam'));
    }
}