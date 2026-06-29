@extends('layouts.admin')

@section('title', 'Detail Kandang')
@section('header', 'Detail Kandang')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-start space-x-4">
            <div>
                @if($kandang->foto)
                    <img src="{{ $kandang->foto_url }}" class="w-32 h-32 object-cover rounded">
                @else
                    <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                        <i class="fas fa-warehouse text-4xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold">{{ $kandang->nama }}</h3>
                <p class="text-gray-600">Kode: {{ $kandang->kode_kandang }}</p>
                <p class="text-gray-600">Lokasi: {{ $kandang->lokasi }}</p>
                <p class="text-gray-600">Kapasitas: {{ $kandang->kapasitas }} ekor</p>
                <p class="text-gray-600">Ayam Aktif: {{ $kandang->jumlah_ayam_aktif }} ekor</p>
                <p class="text-gray-600">
                    Status: 
                    <span class="px-2 py-1 text-xs rounded 
                        @if($kandang->status == 'aktif') bg-green-100 text-green-800
                        @elseif($kandang->status == 'nonaktif') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $kandang->status_label }}
                    </span>
                </p>
                <p class="text-gray-600 mt-2">Dibuat oleh: {{ $kandang->creator->name }}</p>
                <p class="text-gray-600 text-sm">Dibuat: {{ $kandang->created_at->format('d/m/Y H:i') }}</p>
                @if($kandang->deskripsi)
                    <p class="text-gray-700 mt-2">{{ $kandang->deskripsi }}</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="font-semibold mb-4">Daftar Ayam di Kandang</h4>
        @if($kandang->ayams->count() > 0)
            <ul class="space-y-2">
                @foreach($kandang->ayams->take(5) as $ayam)
                    <li class="flex justify-between items-center border-b pb-1">
                        <span>{{ $ayam->kode_ayam }}</span>
                        <span class="text-xs px-2 py-1 rounded 
                            @if($ayam->status_kesehatan == 'sehat') bg-green-100 text-green-800
                            @elseif($ayam->status_kesehatan == 'sakit') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $ayam->status_kesehatan_label }}
                        </span>
                    </li>
                @endforeach
                @if($kandang->ayams->count() > 5)
                    <li class="text-sm text-gray-500">...dan {{ $kandang->ayams->count() - 5 }} lainnya</li>
                @endif
            </ul>
        @else
            <p class="text-gray-500 text-sm">Belum ada ayam di kandang ini</p>
        @endif
    </div>
</div>
@endsection