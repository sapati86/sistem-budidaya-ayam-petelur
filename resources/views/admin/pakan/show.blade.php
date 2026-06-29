@extends('layouts.admin')

@section('title', 'Detail Pakan')
@section('header', 'Detail Pakan')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-start space-x-4">
            <div>
                @if($pakan->foto)
                    <img src="{{ $pakan->foto_url }}" class="w-32 h-32 object-cover rounded">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-box text-4xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold">{{ $pakan->nama }}</h3>
                <p class="text-gray-600">Kode: {{ $pakan->kode_pakan }}</p>
                <p class="text-gray-600">Jenis: {{ $pakan->jenis_label }}</p>
                <p class="text-gray-600">Stok: {{ $pakan->stok }} {{ $pakan->satuan }}</p>
                <p class="text-gray-600">Stok Minimal: {{ $pakan->stok_minimal }} {{ $pakan->satuan }}</p>
                <p class="text-gray-600">Harga: Rp {{ number_format($pakan->harga_satuan, 0, ',', '.') }}</p>
                <p class="text-gray-600">Kadaluarsa: {{ $pakan->tanggal_kadaluarsa->format('d/m/Y') }}</p>
                <p class="text-gray-600 mt-2">Dibuat oleh: {{ $pakan->creator->name }}</p>
                <p class="text-gray-600 text-sm">Dibuat: {{ $pakan->created_at->format('d/m/Y H:i') }}</p>
                @if($pakan->keterangan)
                    <p class="text-gray-700 mt-2">{{ $pakan->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="font-semibold mb-4">Status</h4>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span>Status Stok:</span>
                @if($pakan->isStokMenipis())
                    <span class="text-red-600 font-semibold">⚠️ Menipis</span>
                @else
                    <span class="text-green-600 font-semibold">✅ Tersedia</span>
                @endif
            </div>
            <div class="flex justify-between">
                <span>Status Kadaluarsa:</span>
                @if($pakan->isKadaluarsa())
                    <span class="text-red-600 font-semibold">❌ Kadaluarsa</span>
                @else
                    <span class="text-green-600 font-semibold">✅ Masih Berlaku</span>
                @endif
            </div>
        </div>
        
        <h4 class="font-semibold mt-4 mb-2">Riwayat Konsumsi</h4>
        @if($pakan->konsumsiPakans->count() > 0)
            <ul class="space-y-1 text-sm">
                @foreach($pakan->konsumsiPakans->take(5) as $konsumsi)
                    <li class="flex justify-between border-b pb-1">
                        <span>{{ $konsumsi->tanggal->format('d/m/Y') }}</span>
                        <span>{{ $konsumsi->jumlah }} {{ $konsumsi->satuan }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-sm">Belum ada riwayat konsumsi</p>
        @endif
    </div>
</div>
@endsection