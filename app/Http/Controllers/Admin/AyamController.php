<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ayam;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AyamController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified', '2fa']);
    //     $this->middleware('role:admin')->except(['index', 'show']);
    // }

    public function index()
    {
        $ayams = Ayam::with(['kandang'])->latest()->paginate(10);
        return view('admin.ayam.index', compact('ayams'));
    }

    public function create()
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        return view('admin.ayam.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'kode_ayam' => 'required|string|unique:ayams,kode_ayam|max:50',
            'jenis' => 'required|in:pullet,layer,pejantan',
            'umur_hari' => 'required|integer|min:0',
            'status_kesehatan' => 'required|in:sehat,sakit,mati',
            'tanggal_masuk' => 'required|date',
            'tanggal_produksi' => 'nullable|date|after:tanggal_masuk',
            'produksi_telur_per_minggu' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/ayam', $filename);
            $validated['foto'] = $filename;
        }

        DB::transaction(function () use ($validated) {
            $ayam = Ayam::create($validated);
            
            // Update jumlah ayam di kandang
            $kandang = Kandang::find($validated['kandang_id']);
            $kandang->increment('jumlah_ayam_aktif');
        });

        return redirect()->route('admin.ayam.index')
            ->with('success', 'Ayam berhasil ditambahkan!');
    }

    public function show(Ayam $ayam)
    {
        $ayam->load(['kandang', 'kesehatanAyams']);
        return view('admin.ayam.show', compact('ayam'));
    }

    public function edit(Ayam $ayam)
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        return view('admin.ayam.edit', compact('ayam', 'kandangs'));
    }

    public function update(Request $request, Ayam $ayam)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'kode_ayam' => 'required|string|max:50|unique:ayams,kode_ayam,' . $ayam->id,
            'jenis' => 'required|in:pullet,layer,pejantan',
            'umur_hari' => 'required|integer|min:0',
            'status_kesehatan' => 'required|in:sehat,sakit,mati',
            'tanggal_masuk' => 'required|date',
            'tanggal_produksi' => 'nullable|date|after:tanggal_masuk',
            'produksi_telur_per_minggu' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle foto
        if ($request->hasFile('foto')) {
            if ($ayam->foto) {
                Storage::delete('public/ayam/' . $ayam->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('public/ayam', $filename);
            $validated['foto'] = $filename;
        }

        // Jika kandang berubah, update jumlah ayam di kandang
        if ($ayam->kandang_id != $validated['kandang_id']) {
            DB::transaction(function () use ($ayam, $validated) {
                // Kurangi di kandang lama
                Kandang::find($ayam->kandang_id)->decrement('jumlah_ayam_aktif');
                // Tambah di kandang baru
                Kandang::find($validated['kandang_id'])->increment('jumlah_ayam_aktif');
                $ayam->update($validated);
            });
        } else {
            $ayam->update($validated);
        }

        return redirect()->route('admin.ayam.index')
            ->with('success', 'Ayam berhasil diperbarui!');
    }

    public function destroy(Ayam $ayam)
    {
        DB::transaction(function () use ($ayam) {
            // Hapus foto
            if ($ayam->foto) {
                Storage::delete('public/ayam/' . $ayam->foto);
            }

            // Kurangi jumlah ayam di kandang
            Kandang::find($ayam->kandang_id)->decrement('jumlah_ayam_aktif');
            
            $ayam->delete();
        });

        return redirect()->route('admin.ayam.index')
            ->with('success', 'Ayam berhasil dihapus!');
    }
}
