@extends('layouts.user')

@section('title', 'Data Ayam')
@section('header', 'Daftar Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Kandang</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-left">Umur</th>
                    <th class="px-4 py-2 text-left">Status Kesehatan</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ayams as $ayam)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $ayam->kode_ayam ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $ayam->kandang->nama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $ayam->jenis_label ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $ayam->umur_hari ?? 0 }} hari</td>
                    <td class="px-4 py-2">
                        @php
                            $status = $ayam->status_kesehatan ?? 'sehat';
                            $label = $ayam->status_kesehatan_label ?? 'Tidak Diketahui';
                        @endphp
                        <span class="px-2 py-1 text-xs rounded 
                            @if($status == 'sehat') bg-green-100 text-green-800
                            @elseif($status == 'sakit') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('user.ayam.show', $ayam) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data ayam</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $ayams->links() }}
    </div>
</div>
@endsection