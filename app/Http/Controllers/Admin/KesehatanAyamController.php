<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ayam;
use App\Models\KesehatanAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesehatanAyamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->middleware('role:admin');
    }

    public function index()
    {
        $kesehatans = KesehatanAyam::with(['ayam', 'creator'])
            ->latest()
            ->paginate(10);
        return view('admin.kesehatan.index', compact('kesehatans'));
    }

    public function create($ayam_id = null)
    {
        $ayams = Ayam::where('status_kesehatan', '!=', 'mati')->get();
        return view('admin.kesehatan.create', compact('ayams', 'ayam_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ayam_id' => 'required|exists:ayams,id',
            'tanggal' => 'required|date',
            'jenis_penyakit' => 'required|string|max:255',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'status' => 'required|in:sembuh,perawatan,mati',
            'tanggal_sembuh' => 'nullable|date|after:tanggal',
            'keterangan' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();

        // Jika status mati, update status ayam
        if ($validated['status'] == 'mati') {
            $ayam = Ayam::find($validated['ayam_id']);
            $ayam->status_kesehatan = 'mati';
            $ayam->save();
        }

        // Jika status sembuh, set tanggal sembuh
        if ($validated['status'] == 'sembuh') {
            $validated['tanggal_sembuh'] = $validated['tanggal_sembuh'] ?? now();
        }

        KesehatanAyam::create($validated);

        return redirect()->route('admin.kesehatan.index')
            ->with('success', 'Data kesehatan ayam berhasil ditambahkan!');
    }

    public function show(KesehatanAyam $kesehatan)
    {
        $kesehatan->load(['ayam', 'creator']);
        return view('admin.kesehatan.show', compact('kesehatan'));
    }

    public function edit(KesehatanAyam $kesehatan)
    {
        $ayams = Ayam::all();
        return view('admin.kesehatan.edit', compact('kesehatan', 'ayams'));
    }

    public function update(Request $request, KesehatanAyam $kesehatan)
    {
        $validated = $request->validate([
            'ayam_id' => 'required|exists:ayams,id',
            'tanggal' => 'required|date',
            'jenis_penyakit' => 'required|string|max:255',
            'gejala' => 'required|string',
            'tindakan' => 'required|string',
            'status' => 'required|in:sembuh,perawatan,mati',
            'tanggal_sembuh' => 'nullable|date|after:tanggal',
            'keterangan' => 'nullable|string'
        ]);

        // Update status ayam jika status berubah
        if ($validated['status'] == 'mati') {
            $ayam = Ayam::find($validated['ayam_id']);
            $ayam->status_kesehatan = 'mati';
            $ayam->save();
        } else {
            $ayam = Ayam::find($validated['ayam_id']);
            if ($ayam->status_kesehatan == 'mati' && $validated['status'] != 'mati') {
                $ayam->status_kesehatan = 'sehat';
                $ayam->save();
            }
        }

        if ($validated['status'] == 'sembuh') {
            $validated['tanggal_sembuh'] = $validated['tanggal_sembuh'] ?? now();
        }

        $kesehatan->update($validated);

        return redirect()->route('admin.kesehatan.index')
            ->with('success', 'Data kesehatan berhasil diperbarui!');
    }

    public function destroy(KesehatanAyam $kesehatan)
    {
        $kesehatan->delete();
        return redirect()->route('admin.kesehatan.index')
            ->with('success', 'Data kesehatan berhasil dihapus!');
    }
}
