<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\KesehatanAyam;
use App\Models\KonsumsiPakan;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $jenis = $request->input('jenis', 'produksi');

        $data = $this->getLaporanData($bulan, $tahun, $jenis);
        $chartData = $this->getChartData($bulan, $tahun, $jenis);
        $summary = $this->getSummary($bulan, $tahun, $jenis);

        // DEBUG: Cek data
        // \Log::info('Chart Data:', $chartData);

        return view('admin.laporan.index', compact(
            'data',
            'chartData',
            'summary',
            'bulan',
            'tahun',
            'jenis'
        ));
    }

    private function getLaporanData($bulan, $tahun, $jenis)
    {
        switch ($jenis) {
            case 'produksi':
                return ProduksiTelur::with(['kandang', 'creator'])
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);
                break;

            case 'konsumsi':
                return KonsumsiPakan::with(['kandang', 'pakan', 'creator'])
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);
                break;

            case 'kesehatan':
                return KesehatanAyam::with(['ayam', 'creator'])
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);
                break;

            default:
                return collect([]);
        }
    }


    private function getChartData($bulan, $tahun, $jenis)
    {
        $labels = [];
        $datasets = [];

        // Ambil tanggal dalam bulan tersebut
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = $i;

            switch ($jenis) {
                case 'produksi':
                    $total = ProduksiTelur::whereDate('tanggal', $date)->sum('jumlah_produksi');
                    $datasets[] = $total;
                    break;

                case 'konsumsi':
                    $total = KonsumsiPakan::whereDate('tanggal', $date)->sum('jumlah');
                    $datasets[] = $total;
                    break;

                case 'kesehatan':
                    $total = KesehatanAyam::whereDate('tanggal', $date)->count();
                    $datasets[] = $total;
                    break;
            }
        }

        return [
            'labels' => $labels,
            'data' => $datasets,
        ];
    }

    private function getSummary($bulan, $tahun, $jenis)
    {
        $summary = [];

        switch ($jenis) {
            case 'produksi':
                $summary['total'] = ProduksiTelur::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->sum('jumlah_produksi');

                $summary['total_rusak'] = ProduksiTelur::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->sum('jumlah_rusak');

                $summary['rata_rata'] = ProduksiTelur::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->avg('jumlah_produksi') ?? 0;

                $summary['hari_terbanyak'] = ProduksiTelur::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('jumlah_produksi', 'desc')
                    ->first();

                $summary['kandang_terbanyak'] = ProduksiTelur::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->with('kandang')
                    ->select('kandang_id', DB::raw('SUM(jumlah_produksi) as total'))
                    ->groupBy('kandang_id')
                    ->orderBy('total', 'desc')
                    ->first();
                break;

            case 'konsumsi':
                $summary['total'] = KonsumsiPakan::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->sum('jumlah');

                $summary['rata_rata'] = KonsumsiPakan::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->avg('jumlah') ?? 0;

                $summary['pakan_terbanyak'] = KonsumsiPakan::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->with('pakan')
                    ->select('pakan_id', DB::raw('SUM(jumlah) as total'))
                    ->groupBy('pakan_id')
                    ->orderBy('total', 'desc')
                    ->first();

                $summary['hari_terbanyak'] = KonsumsiPakan::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('jumlah', 'desc')
                    ->first();
                break;

            case 'kesehatan':
                $summary['total'] = KesehatanAyam::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->count();

                $summary['sembuh'] = KesehatanAyam::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'sembuh')
                    ->count();

                $summary['perawatan'] = KesehatanAyam::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'perawatan')
                    ->count();

                $summary['mati'] = KesehatanAyam::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status', 'mati')
                    ->count();

                $summary['penyakit_terbanyak'] = KesehatanAyam::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->select('jenis_penyakit', DB::raw('COUNT(*) as total'))
                    ->groupBy('jenis_penyakit')
                    ->orderBy('total', 'desc')
                    ->first();
                break;
        }

        return $summary;
    }

    public function export(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $jenis = $request->input('jenis', 'produksi');
        $data = $this->getLaporanData($bulan, $tahun, $jenis);

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor pada periode ini.');
        }

        $namaFile = 'Laporan_' . ucfirst($jenis) . '_' . $bulan . '_' . $tahun . '.xlsx';

        return Excel::download(new LaporanExport($data, $jenis, $bulan, $tahun), $namaFile);
    }
}