<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PakanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->middleware('role:admin')->except(['index', 'show', 'create', 'store']);
    }

    public function index()
    {
        $produksis = ProduksiTelur::with(['kandang', 'creator'])
            ->latest()
            ->paginate(10);
        
        // Statistik
        $totalHariIni = ProduksiTelur::whereDate('tanggal', today())->sum('jumlah_produksi');
        $totalBulanIni = ProduksiTelur::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah_produksi');
        
        return view('admin.produksi.index', compact('produksis', 'totalHariIni', 'totalBulanIni'));
    }

    public function create()
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        return view('admin.produksi.create', compact('kandangs'));
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/produksi', $filename);
            $validated['foto'] = $filename;
        }

        $validated['created_by'] = Auth::id();
        ProduksiTelur::create($validated);

        return redirect()->route('admin.produksi.index')
            ->with('success', 'Data produksi telur berhasil ditambahkan!');
    }

    public function show(ProduksiTelur $produksi)
    {
        $produksi->load(['kandang', 'creator']);
        return view('admin.produksi.show', compact('produksi'));
    }

    public function edit(ProduksiTelur $produksi)
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        return view('admin.produksi.edit', compact('produksi', 'kandangs'));
    }

    public function update(Request $request, ProduksiTelur $produksi)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'tanggal' => 'required|date',
            'jumlah_produksi' => 'required|integer|min:0',
            'jumlah_rusak' => 'nullable|integer|min:0|lte:jumlah_produksi',
            'kualitas' => 'required|in:A,B,C',
            'berat_rata_rata' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($produksi->foto) {
                Storage::delete('public/produksi/' . $produksi->foto);
            }
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/produksi', $filename);
            $validated['foto'] = $filename;
        }

        $produksi->update($validated);

        return redirect()->route('admin.produksi.index')
            ->with('success', 'Data produksi berhasil diperbarui!');
    }

    public function destroy(ProduksiTelur $produksi)
    {
        if ($produksi->foto) {
            Storage::delete('public/produksi/' . $produksi->foto);
        }
        $produksi->delete();

        return redirect()->route('admin.produksi.index')
            ->with('success', 'Data produksi berhasil dihapus!');
    }
}
