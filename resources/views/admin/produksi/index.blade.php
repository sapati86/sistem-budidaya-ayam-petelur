@extends('layouts.admin')

@section('title', 'Data Produksi Telur')
@section('header', 'Manajemen Produksi Telur')

@section('content')
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Produksi Hari Ini</div>
        <div class="text-2xl font-bold text-blue-600">{{ number_format($totalHariIni) }} butir</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Produksi Bulan Ini</div>
        <div class="text-2xl font-bold text-green-600">{{ number_format($totalBulanIni) }} butir</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Rata-rata Harian</div>
        <div class="text-2xl font-bold text-purple-600">
            {{ $produksis->count() > 0 ? number_format($totalBulanIni / $produksis->count(), 1) : 0 }} butir
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Produksi</h3>
        <a href="{{ route('admin.produksi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i> Tambah Produksi
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Kandang</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Rusak</th>
                    <th class="px-4 py-2 text-left">Kualitas</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produksis as $produksi)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $produksi->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $produksi->kandang->nama }}</td>
                    <td class="px-4 py-2 font-semibold">{{ number_format($produksi->jumlah_produksi) }}</td>
                    <td class="px-4 py-2 text-red-500">{{ number_format($produksi->jumlah_rusak) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($produksi->kualitas == 'A') bg-green-100 text-green-800
                            @elseif($produksi->kualitas == 'B') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            Grade {{ $produksi->kualitas }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.produksi.show', $produksi) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.produksi.edit', $produksi) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.produksi.destroy', $produksi) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data produksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $produksis->links() }}
    </div>
</div>
@endsection