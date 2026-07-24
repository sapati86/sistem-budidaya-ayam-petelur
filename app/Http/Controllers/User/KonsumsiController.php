<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\KonsumsiPakan;
use App\Models\Pakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonsumsiController extends Controller
{

    public function index()
    {
        $konsumsis = KonsumsiPakan::with(['kandang', 'pakan', 'creator'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.konsumsi.index', compact('konsumsis'));
    }

    public function create()
    {
        $kandangs = Kandang::where('status', 'aktif')->get();
        $pakans = Pakan::where('stok', '>', 0)->get();
        return view('user.konsumsi.create', compact('kandangs', 'pakans'));
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
            $pakan = Pakan::find($validated['pakan_id']);
            if ($pakan->stok < $validated['jumlah']) {
                throw new \Exception('Stok pakan tidak mencukupi!');
            }
            $pakan->decrement('stok', $validated['jumlah']);

            KonsumsiPakan::create($validated);
        });

        return redirect()->route('user.konsumsi.index')
            ->with('success', 'Data konsumsi pakan berhasil ditambahkan!');
    }

    public function show(KonsumsiPakan $konsumsi)
    {

        if ($konsumsi->created_by !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $konsumsi->load(['kandang', 'pakan', 'creator']);
        return view('user.konsumsi.show', compact('konsumsi'));
    }
}