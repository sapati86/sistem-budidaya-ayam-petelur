@extends('layouts.admin')

@section('title', 'Detail Ayam')
@section('header', 'Detail Data Ayam')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-start space-x-4">
            <div>
                @if($ayam->foto)
                    <img src="{{ asset('storage/ayam/' . $ayam->foto) }}" class="w-32 h-32 object-cover rounded">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-dove text-4xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold">{{ $ayam->kode_ayam }}</h3>
                <p class="text-gray-600">Jenis: {{ $ayam->jenis_label }}</p>
                <p class="text-gray-600">Kandang: {{ $ayam->kandang->nama ?? '-' }}</p>
                <p class="text-gray-600">Umur: {{ $ayam->umur_hari }} hari</p>
                <p class="text-gray-600">Status Kesehatan: 
                    <span class="px-2 py-1 text-xs rounded 
                        @if($ayam->status_kesehatan == 'sehat') bg-green-100 text-green-800
                        @elseif($ayam->status_kesehatan == 'sakit') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $ayam->status_kesehatan_label }}
                    </span>
                </p>
                <p class="text-gray-600">Tanggal Masuk: {{ $ayam->tanggal_masuk->format('d/m/Y') }}</p>
                @if($ayam->tanggal_produksi)
                    <p class="text-gray-600">Tanggal Produksi: {{ $ayam->tanggal_produksi->format('d/m/Y') }}</p>
                @endif
                @if($ayam->produksi_telur_per_minggu > 0)
                    <p class="text-gray-600">Produksi Telur: {{ $ayam->produksi_telur_per_minggu }} butir/minggu</p>
                @endif
                <p class="text-gray-600 text-sm mt-2">Dibuat: {{ $ayam->created_at->format('d/m/Y H:i') }}</p>
                @if($ayam->keterangan)
                    <p class="text-gray-700 mt-2">{{ $ayam->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="font-semibold mb-4">Riwayat Kesehatan</h4>
        @if($ayam->kesehatanAyams->count() > 0)
            <ul class="space-y-2 text-sm">
                @foreach($ayam->kesehatanAyams->take(5) as $kesehatan)
                    <li class="border-b pb-2">
                        <p class="font-medium">{{ $kesehatan->jenis_penyakit }}</p>
                        <p class="text-gray-500">{{ $kesehatan->tanggal->format('d/m/Y') }}</p>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($kesehatan->status == 'sembuh') bg-green-100 text-green-800
                            @elseif($kesehatan->status == 'perawatan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $kesehatan->status_label }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-sm">Belum ada riwayat kesehatan</p>
        @endif
    </div>
</div>
@endsection