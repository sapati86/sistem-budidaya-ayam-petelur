@extends('layouts.user')

@section('title', 'Detail Konsumsi')
@section('header', 'Detail Data Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold mb-4">Informasi Konsumsi</h3>
            <table class="w-full">
                <tr><td class="py-2 text-gray-600">Tanggal</td><td class="py-2 font-medium">{{ $konsumsi->tanggal->format('d/m/Y') }}</td></tr>
                <tr><td class="py-2 text-gray-600">Kandang</td><td class="py-2 font-medium">{{ $konsumsi->kandang->nama ?? '-' }}</td></tr>
                <tr><td class="py-2 text-gray-600">Pakan</td><td class="py-2 font-medium">{{ $konsumsi->pakan->nama ?? '-' }}</td></tr>
                <tr><td class="py-2 text-gray-600">Jumlah</td><td class="py-2 font-medium">{{ number_format($konsumsi->jumlah) }} {{ $konsumsi->satuan }}</td></tr>
                <tr><td class="py-2 text-gray-600">Dicatat oleh</td><td class="py-2 font-medium">{{ $konsumsi->creator->name ?? '-' }}</td></tr>
                @if($konsumsi->keterangan)
                <tr><td class="py-2 text-gray-600">Keterangan</td><td class="py-2 font-medium">{{ $konsumsi->keterangan }}</td></tr>
                @endif
            </table>
        </div>
        <div>
            <h3 class="font-semibold mb-4">Detail Pakan</h3>
            <div class="bg-gray-50 rounded p-4">
                <p><span class="text-gray-600">Kode:</span> {{ $konsumsi->pakan->kode_pakan ?? '-' }}</p>
                <p><span class="text-gray-600">Jenis:</span> {{ $konsumsi->pakan->jenis_label ?? '-' }}</p>
                <p><span class="text-gray-600">Stok Tersisa:</span> {{ $konsumsi->pakan->stok ?? 0 }} {{ $konsumsi->pakan->satuan ?? 'kg' }}</p>
                <p><span class="text-gray-600">Kadaluarsa:</span> {{ $konsumsi->pakan->tanggal_kadaluarsa ? $konsumsi->pakan->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection