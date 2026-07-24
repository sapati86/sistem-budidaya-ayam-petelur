<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduksiController extends Controller
{
    public function index()
    {
        $produksis = ProduksiTelur::with(['kandang', 'creator'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);
        return view('user.produksi.index', compact('produksis'));
    }

    public function create()
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        return view('user.produksi.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'tanggal' => 'required|date',
            'jumlah_produksi' => 'required|integer|min:0',
            'jumlah_rusak' => 'nullable|integer|min:0|lte:jumlah_produksi',
            'kualitas' => 'required|in:A,B,C',
            'berat_rata_rata' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        ProduksiTelur::create($validated);

        return redirect()->route('user.produksi.index')
            ->with('success', 'Data produksi berhasil ditambahkan!');
    }

    public function show(ProduksiTelur $produksi)
    {
        if ($produksi->created_by !== Auth::id()) {
            abort(403);
        }
        return view('user.produksi.show', compact('produksi'));
    }
}