<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KandangController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified', '2fa']);
    //     $this->middleware('role:admin')->except(['index', 'show']);
    // }

    public function index()
    {
        $kandangs = Kandang::with('creator')->latest()->paginate(10);
        return view('admin.kandang.index', compact('kandangs'));
    }

    public function create()
    {
        return view('admin.kandang.create');
    }

    public function store(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            'kode_kandang' => 'required|string|unique:kandangs,kode_kandang|max:50',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif,perawatan',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // HANDLE FOTO UPLOAD
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            
            // Generate nama unik
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $foto->getClientOriginalExtension();
            
            // === PERBAIKAN: Gunakan store() dengan path yang benar ===
            // Simpan ke storage/app/public/kandang
            $path = $foto->store('kandang', 'public');
            
            // Atau cara manual:
            // $path = $foto->storeAs('public/kandang', $filename);
            
            if ($path) {
                // Simpan hanya nama file ke database (tanpa path)
                $validated['foto'] = basename($path);
            } else {
                return back()->withErrors(['foto' => 'Gagal mengupload foto.']);
            }
        }

        $validated['created_by'] = Auth::id();
        $validated['jumlah_ayam_aktif'] = 0;

        $kandang = Kandang::create($validated);

        // DEBUG: Cek apakah foto tersimpan
        // dd($kandang->foto, storage_path('app/public/kandang/' . $kandang->foto));

        return redirect()->route('admin.kandang.index')
            ->with('success', 'Kandang berhasil ditambahkan!');
    }


    public function show(Kandang $kandang)
    {
        $kandang->load(['ayams', 'creator']);
        return view('admin.kandang.show', compact('kandang'));
    }

    public function edit(Kandang $kandang)
    {
        return view('admin.kandang.edit', compact('kandang'));
    }

    public function update(Request $request, Kandang $kandang)
    {
        $validated = $request->validate([
            'kode_kandang' => 'required|string|max:50|unique:kandangs,kode_kandang,' . $kandang->id,
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif,perawatan',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($kandang->foto) {
                Storage::delete('public/kandang/' . $kandang->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/kandang', $filename);
            $validated['foto'] = $filename;
        }

        $kandang->update($validated);

        return redirect()->route('admin.kandang.index')
            ->with('success', 'Kandang berhasil diperbarui!');
    }

    public function destroy(Kandang $kandang)
    {
        // Hapus foto
        if ($kandang->foto) {
            Storage::delete('public/kandang/' . $kandang->foto);
        }

        $kandang->delete();

        return redirect()->route('admin.kandang.index')
            ->with('success', 'Kandang berhasil dihapus!');
    }
}
