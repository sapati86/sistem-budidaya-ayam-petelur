@extends('layouts.admin')

@section('title', 'Laporan')
@section('header', 'Laporan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                <select name="jenis" class="border rounded px-3 py-2">
                    <option value="produksi" {{ request('jenis', 'produksi') == 'produksi' ? 'selected' : '' }}>Produksi Telur</option>
                    <option value="konsumsi" {{ request('jenis') == 'konsumsi' ? 'selected' : '' }}>Konsumsi Pakan</option>
                    <option value="kesehatan" {{ request('jenis') == 'kesehatan' ? 'selected' : '' }}>Kesehatan Ayam</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="bulan" class="border rounded px-3 py-2">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan', date('n')) == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" class="border rounded px-3 py-2">
                    @for ($i = date('Y'); $i >= date('Y') - 2; $i--)
                        <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    <i class="fas fa-filter mr-2"></i> Tampilkan
                </button>
                <a href="{{ route('admin.laporan.export') }}?{{ http_build_query(request()->all()) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    <i class="fas fa-file-pdf mr-2"></i> Export Excell
                </a>
            </div>

        </form>
    </div>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
            <div class="text-sm text-blue-600">Total</div>
            <div class="text-2xl font-bold text-blue-800">
                @if($jenis == 'produksi')
                    {{ number_format($summary['total'] ?? 0) }} butir
                @elseif($jenis == 'konsumsi')
                    {{ number_format($summary['total'] ?? 0) }} kg
                @else
                    {{ number_format($summary['total'] ?? 0) }} kasus
                @endif
            </div>
        </div>

        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
            <div class="text-sm text-green-600">Rata-rata / Hari</div>
            <div class="text-2xl font-bold text-green-800">
                @if($jenis == 'produksi')
                    {{ number_format($summary['rata_rata'] ?? 0, 1) }} butir
                @elseif($jenis == 'konsumsi')
                    {{ number_format($summary['rata_rata'] ?? 0, 1) }} kg
                @else
                    {{ number_format($summary['rata_rata'] ?? 0, 1) }} kasus
                @endif
            </div>
        </div>

        @if($jenis == 'produksi')
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="text-sm text-red-600">Total Rusak</div>
                <div class="text-2xl font-bold text-red-800">
                    {{ number_format($summary['total_rusak'] ?? 0) }} butir
                </div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <div class="text-sm text-purple-600">Kandang Terbanyak</div>
                <div class="text-lg font-bold text-purple-800 truncate">
                    {{ $summary['kandang_terbanyak']->kandang->nama ?? '-' }}
                    <span class="text-sm font-normal">
                        ({{ number_format($summary['kandang_terbanyak']->total ?? 0) }})
                    </span>
                </div>
            </div>
        @elseif($jenis == 'konsumsi')
            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                <div class="text-sm text-yellow-600">Pakan Terbanyak</div>
                <div class="text-lg font-bold text-yellow-800 truncate">
                    {{ $summary['pakan_terbanyak']->pakan->nama ?? '-' }}
                    <span class="text-sm font-normal">
                        ({{ number_format($summary['pakan_terbanyak']->total ?? 0) }} kg)
                    </span>
                </div>
            </div>
            <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                <div class="text-sm text-orange-600">Hari Konsumsi Terbanyak</div>
                <div class="text-lg font-bold text-orange-800">
                    {{ isset($summary['hari_terbanyak']) ? $summary['hari_terbanyak']->tanggal->format('d/m/Y') : '-' }}
                    <span class="text-sm font-normal">
                        ({{ number_format($summary['hari_terbanyak']->jumlah ?? 0) }} kg)
                    </span>
                </div>
            </div>
        @elseif($jenis == 'kesehatan')
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <div class="text-sm text-green-600">Sembuh</div>
                <div class="text-2xl font-bold text-green-800">
                    {{ number_format($summary['sembuh'] ?? 0) }}
                </div>
            </div>
            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                <div class="text-sm text-red-600">Penyakit Terbanyak</div>
                <div class="text-lg font-bold text-red-800 truncate">
                    {{ $summary['penyakit_terbanyak']->jenis_penyakit ?? '-' }}
                    <span class="text-sm font-normal">
                        ({{ number_format($summary['penyakit_terbanyak']->total ?? 0) }} kasus)
                    </span>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-6">
        <h3 class="font-semibold text-lg mb-4">Grafik Harian</h3>
        <div class="bg-gray-50 rounded-lg p-4" style="height: 300px; position: relative;">
            <canvas id="laporanChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>

    <div>
        <h3 class="font-semibold text-lg mb-4">Data Detail</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        @if($jenis == 'produksi')
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Kandang</th>
                            <th class="px-4 py-2 text-right">Jumlah</th>
                            <th class="px-4 py-2 text-right">Rusak</th>
                            <th class="px-4 py-2 text-left">Kualitas</th>
                            <th class="px-4 py-2 text-left">Dicatat oleh</th>
                        @elseif($jenis == 'konsumsi')
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Kandang</th>
                            <th class="px-4 py-2 text-left">Pakan</th>
                            <th class="px-4 py-2 text-right">Jumlah</th>
                            <th class="px-4 py-2 text-left">Dicatat oleh</th>
                        @else
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Ayam</th>
                            <th class="px-4 py-2 text-left">Penyakit</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Dicatat oleh</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr class="border-t">
                            @if($jenis == 'produksi')
                                <td class="px-4 py-2">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $item->kandang->nama ?? '-' }}</td>
                                <td class="px-4 py-2 text-right font-semibold">{{ number_format($item->jumlah_produksi) }}</td>
                                <td class="px-4 py-2 text-right text-red-500">{{ number_format($item->jumlah_rusak) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded 
                                        @if($item->kualitas == 'A') bg-green-100 text-green-800
                                        @elseif($item->kualitas == 'B') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        Grade {{ $item->kualitas }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $item->creator->name ?? '-' }}</td>
                            @elseif($jenis == 'konsumsi')
                                <td class="px-4 py-2">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $item->kandang->nama ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->pakan->nama ?? '-' }}</td>
                                <td class="px-4 py-2 text-right font-semibold">{{ number_format($item->jumlah) }} kg</td>
                                <td class="px-4 py-2">{{ $item->creator->name ?? '-' }}</td>
                            @else
                                <td class="px-4 py-2">{{ $item->tanggal->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $item->ayam->kode_ayam ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->jenis_penyakit }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded 
                                        @if($item->status == 'sembuh') bg-green-100 text-green-800
                                        @elseif($item->status == 'perawatan') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $item->creator->name ?? '-' }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data untuk periode ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>
</div>


<script>
    window.chartData = {
        labels: @json($chartData['labels'] ?? []),
        data: @json($chartData['data'] ?? []),
        label: '{{ $jenis == 'produksi' ? 'Produksi Telur (butir)' : ($jenis == 'konsumsi' ? 'Konsumsi Pakan (kg)' : 'Kasus Kesehatan') }}'
    };
</script>


@vite(['resources/js/laporan.js'])

@endsection

