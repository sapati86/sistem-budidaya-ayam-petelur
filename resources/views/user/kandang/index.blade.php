@extends('layouts.user')

@section('title', 'Data Kandang')
@section('header', 'Daftar Kandang')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Kapasitas</th>
                    <th class="px-4 py-2 text-left">Ayam Aktif</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kandangs as $kandang)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $kandang->kode_kandang }}</td>
                    <td class="px-4 py-2">{{ $kandang->nama }}</td>
                    <td class="px-4 py-2">{{ $kandang->kapasitas }}</td>
                    <td class="px-4 py-2">{{ $kandang->jumlah_ayam_aktif }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($kandang->status == 'aktif') bg-green-100 text-green-800
                            @elseif($kandang->status == 'nonaktif') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $kandang->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('user.kandang.show', $kandang) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data kandang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $kandangs->links() }}
    </div>
</div>
@endsection