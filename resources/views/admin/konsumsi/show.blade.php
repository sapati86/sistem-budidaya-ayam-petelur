@extends('layouts.admin')

@section('title', 'Detail Konsumsi Pakan')
@section('header', 'Detail Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Informasi Konsumsi</h3>
            <table class="w-full">
                <tr>
                    <td class="py-2 text-gray-600">Tanggal</td>
                    <td class="py-2 font-medium">{{ $konsumsi->tanggal->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Kandang</td>
                    <td class="py-2 font-medium">{{ $konsumsi->kandang->nama }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Pakan</td>
                    <td class="py-2 font-medium">{{ $konsumsi->pakan->nama }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Jumlah</td>
                    <td class="py-2 font-medium">{{ number_format($konsumsi->jumlah) }} {{ $konsumsi->satuan }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Dibuat oleh</td>
                    <td class="py-2 font-medium">{{ $konsumsi->creator->name }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Dibuat pada</td>
                    <td class="py-2 font-medium">{{ $konsumsi->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @if($konsumsi->keterangan)
                <tr>
                    <td class="py-2 text-gray-600">Keterangan</td>
                    <td class="py-2 font-medium">{{ $konsumsi->keterangan }}</td>
                </tr>
                @endif
            </table>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold mb-4">Detail Pakan</h3>
            <div class="bg-gray-50 rounded p-4">
                <p><span class="text-gray-600">Kode Pakan:</span> {{ $konsumsi->pakan->kode_pakan }}</p>
                <p><span class="text-gray-600">Jenis:</span> {{ $konsumsi->pakan->jenis_label }}</p>
                <p><span class="text-gray-600">Stok Tersisa:</span> {{ $konsumsi->pakan->stok }} {{ $konsumsi->pakan->satuan }}</p>
                <p><span class="text-gray-600">Kadaluarsa:</span> {{ $konsumsi->pakan->tanggal_kadaluarsa->format('d/m/Y') }}</p>
                <p><span class="text-gray-600">Harga:</span> Rp {{ number_format($konsumsi->pakan->harga_satuan, 0, ',', '.') }}</p>
                @if($konsumsi->pakan->isStokMenipis())
                    <p class="text-red-500 mt-2">⚠️ Stok pakan menipis!</p>
                @endif
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.pakan.show', $konsumsi->pakan_id) }}" class="text-blue-500 hover:underline">
                    <i class="fas fa-external-link-alt mr-1"></i> Lihat Detail Pakan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection