@extends('layouts.admin')

@section('title', 'Detail Produksi Telur')
@section('header', 'Detail Data Produksi Telur')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-start space-x-4">
        <div>
            @if($produksi->foto)
                <img src="{{ asset('storage/produksi/' . $produksi->foto) }}" class="w-32 h-32 object-cover rounded">
            @else
                <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                    <i class="fas fa-egg text-4xl"></i>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h3 class="text-2xl font-bold">Produksi Telur</h3>
            <p class="text-gray-600">Tanggal: {{ $produksi->tanggal->format('d/m/Y') }}</p>
            <p class="text-gray-600">Kandang: {{ $produksi->kandang->nama ?? '-' }}</p>
            <p class="text-gray-600">Jumlah Produksi: <span class="font-semibold">{{ number_format($produksi->jumlah_produksi) }}</span> butir</p>
            <p class="text-gray-600">Jumlah Rusak: <span class="text-red-500">{{ number_format($produksi->jumlah_rusak) }}</span> butir</p>
            <p class="text-gray-600">Total Bersih: <span class="font-semibold text-green-600">{{ number_format($produksi->total_produksi) }}</span> butir</p>
            <p class="text-gray-600">Kualitas: {{ $produksi->kualitas_label }}</p>
            @if($produksi->berat_rata_rata)
                <p class="text-gray-600">Berat Rata-rata: {{ $produksi->berat_rata_rata }} gram</p>
            @endif
            <p class="text-gray-600 mt-2">Dibuat oleh: {{ $produksi->creator->name ?? '-' }}</p>
            <p class="text-gray-600 text-sm">Dibuat: {{ $produksi->created_at->format('d/m/Y H:i') }}</p>
            @if($produksi->keterangan)
                <p class="text-gray-700 mt-2">{{ $produksi->keterangan }}</p>
            @endif
        </div>
    </div>
</div>
@endsection