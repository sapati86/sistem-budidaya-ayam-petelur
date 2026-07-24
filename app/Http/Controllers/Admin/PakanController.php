<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PakanController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified', '2fa']);
    //     $this->middleware('role:admin')->except(['index', 'show']);
    // }

    public function index()
    {
        $pakans = Pakan::with('creator')->latest()->paginate(10);
        $stokMenipis = Pakan::all()->filter->isStokMenipis();
        return view('admin.pakan.index', compact('pakans', 'stokMenipis'));
    }

    public function create()
    {
        return view('admin.pakan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pakan' => 'required|string|unique:pakans,kode_pakan|max:50',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:konsentrat,jagung,dedak,premix,lainnya',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'required|date|after:today',
            'stok_minimal' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/pakan', $filename);
            $validated['foto'] = $filename;
        }

        $validated['created_by'] = Auth::id();
        Pakan::create($validated);

        return redirect()->route('admin.pakan.index')
            ->with('success', 'Pakan berhasil ditambahkan!');
    }

    public function show(Pakan $pakan)
    {
        $pakan->load(['creator', 'konsumsiPakans']);
        return view('admin.pakan.show', compact('pakan'));
    }

    public function edit(Pakan $pakan)
    {
        return view('admin.pakan.edit', compact('pakan'));
    }

    public function update(Request $request, Pakan $pakan)
    {
        $validated = $request->validate([
            'kode_pakan' => 'required|string|max:50|unique:pakans,kode_pakan,' . $pakan->id,
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:konsentrat,jagung,dedak,premix,lainnya',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'required|date|after:today',
            'stok_minimal' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($pakan->foto) {
                Storage::delete('public/pakan/' . $pakan->foto);
            }
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/pakan', $filename);
            $validated['foto'] = $filename;
        }

        $pakan->update($validated);

        return redirect()->route('admin.pakan.index')
            ->with('success', 'Pakan berhasil diperbarui!');
    }

    public function destroy(Pakan $pakan)
    {
        if ($pakan->foto) {
            Storage::delete('public/pakan/' . $pakan->foto);
        }
        $pakan->delete();

        return redirect()->route('admin.pakan.index')
            ->with('success', 'Pakan berhasil dihapus!');
    }
}