<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ayam;
use App\Models\KesehatanAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesehatanController extends Controller
{
    /**
     * Display a listing of user's health records.
     */
    public function index()
    {
        $kesehatans = KesehatanAyam::with(['ayam', 'creator'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.kesehatan.index', compact('kesehatans'));
    }

    /**
     * Show the form for creating a new health record.
     */
    public function create()
    {
        $ayams = Ayam::where('status_kesehatan', '!=', 'mati')->get();
        return view('user.kesehatan.create', compact('ayams'));
    }

    /**
     * Store a newly created health record.
     */
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
            $ayam->update(['status_kesehatan' => 'mati']);
        }

        // Jika status sembuh, set tanggal sembuh
        if ($validated['status'] == 'sembuh') {
            $validated['tanggal_sembuh'] = $validated['tanggal_sembuh'] ?? now();
            // Update status ayam menjadi sehat
            $ayam = Ayam::find($validated['ayam_id']);
            $ayam->update(['status_kesehatan' => 'sehat']);
        }

        KesehatanAyam::create($validated);

        return redirect()->route('user.kesehatan.index')
            ->with('success', 'Data kesehatan ayam berhasil ditambahkan!');
    }

    /**
     * Display the specified health record.
     */
    public function show(KesehatanAyam $kesehatan)
    {
        // Pastikan user hanya bisa melihat data miliknya sendiri
        if ($kesehatan->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $kesehatan->load(['ayam', 'creator']);
        return view('user.kesehatan.show', compact('kesehatan'));
    }
}