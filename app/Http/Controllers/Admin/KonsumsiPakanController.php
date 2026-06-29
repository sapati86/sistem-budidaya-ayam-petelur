<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\KonsumsiPakan;
use App\Models\Pakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonsumsiPakanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->middleware('role:admin')->except(['index', 'show', 'create', 'store']);
    }

    public function index()
    {
        $konsumsi = KonsumsiPakan::with(['kandang', 'pakan', 'creator'])
            ->latest()
            ->paginate(10);
        
        $totalKonsumsi = KonsumsiPakan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');
        
        return view('admin.konsumsi.index', compact('konsumsi', 'totalKonsumsi'));
    }

    public function create()
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        $pakans = Pakan::where('stok', '>', 0)->get();
        return view('admin.konsumsi.create', compact('kandangs', 'pakans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'pakan_id' => 'required|exists:pakans,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:20',
            'keterangan' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();

        DB::transaction(function () use ($validated) {
            // Kurangi stok pakan
            $pakan = Pakan::find($validated['pakan_id']);
            if ($pakan->stok < $validated['jumlah']) {
                throw new \Exception('Stok pakan tidak mencukupi!');
            }
            $pakan->decrement('stok', $validated['jumlah']);

            KonsumsiPakan::create($validated);
        });

        return redirect()->route('admin.konsumsi.index')
            ->with('success', 'Data konsumsi pakan berhasil ditambahkan!');
    }

    public function show(KonsumsiPakan $konsumsi)
    {
        $konsumsi->load(['kandang', 'pakan', 'creator']);
        return view('admin.konsumsi.show', compact('konsumsi'));
    }

    public function edit(KonsumsiPakan $konsumsi)
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        $pakans = Pakan::all();
        return view('admin.konsumsi.edit', compact('konsumsi', 'kandangs', 'pakans'));
    }

    public function update(Request $request, KonsumsiPakan $konsumsi)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandangs,id',
            'pakan_id' => 'required|exists:pakans,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:20',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated, $konsumsi) {
            // Kembalikan stok lama
            $pakanLama = Pakan::find($konsumsi->pakan_id);
            $pakanLama->increment('stok', $konsumsi->jumlah);

            // Kurangi stok baru
            $pakanBaru = Pakan::find($validated['pakan_id']);
            if ($pakanBaru->stok < $validated['jumlah']) {
                throw new \Exception('Stok pakan tidak mencukupi!');
            }
            $pakanBaru->decrement('stok', $validated['jumlah']);

            $konsumsi->update($validated);
        });

        return redirect()->route('admin.konsumsi.index')
            ->with('success', 'Data konsumsi pakan berhasil diperbarui!');
    }

    public function destroy(KonsumsiPakan $konsumsi)
    {
        DB::transaction(function () use ($konsumsi) {
            // Kembalikan stok pakan
            $pakan = Pakan::find($konsumsi->pakan_id);
            $pakan->increment('stok', $konsumsi->jumlah);

            $konsumsi->delete();
        });

        return redirect()->route('admin.konsumsi.index')
            ->with('success', 'Data konsumsi pakan berhasil dihapus!');
    }
}
