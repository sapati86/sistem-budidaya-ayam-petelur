@extends('layouts.user')

@section('title', 'Detail Kesehatan')
@section('header', 'Detail Data Kesehatan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold mb-4">Informasi Kesehatan</h3>
            <table class="w-full">
                <tr><td class="py-2 text-gray-600">Ayam</td><td class="py-2 font-medium">{{ $kesehatan->ayam->kode_ayam ?? '-' }}</td></tr>
                <tr><td class="py-2 text-gray-600">Tanggal</td><td class="py-2 font-medium">{{ $kesehatan->tanggal->format('d/m/Y') }}</td></tr>
                <tr><td class="py-2 text-gray-600">Jenis Penyakit</td><td class="py-2 font-medium">{{ $kesehatan->jenis_penyakit }}</td></tr>
                <tr><td class="py-2 text-gray-600">Status</td>
                    <td class="py-2 font-medium">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($kesehatan->status == 'sembuh') bg-green-100 text-green-800
                            @elseif($kesehatan->status == 'perawatan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $kesehatan->status_label ?? $kesehatan->status }}
                        </span>
                    </td>
                </tr>
                @if($kesehatan->tanggal_sembuh)
                <tr><td class="py-2 text-gray-600">Tanggal Sembuh</td><td class="py-2 font-medium">{{ $kesehatan->tanggal_sembuh->format('d/m/Y') }}</td></tr>
                @endif
                <tr><td class="py-2 text-gray-600">Dicatat oleh</td><td class="py-2 font-medium">{{ $kesehatan->creator->name ?? '-' }}</td></tr>
            </table>
        </div>
        <div>
            <h3 class="font-semibold mb-4">Detail</h3>
            <div class="bg-gray-50 rounded p-4 space-y-3">
                <div><p class="text-gray-600 text-sm">Gejala</p><p class="font-medium">{{ $kesehatan->gejala }}</p></div>
                <div><p class="text-gray-600 text-sm">Tindakan</p><p class="font-medium">{{ $kesehatan->tindakan }}</p></div>
                @if($kesehatan->keterangan)
                <div><p class="text-gray-600 text-sm">Keterangan</p><p class="font-medium">{{ $kesehatan->keterangan }}</p></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection