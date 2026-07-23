@extends('layouts.user')

@section('title', 'Data Produksi')
@section('header', 'Data Produksi Telur')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Produksi</h3>
        <a href="{{ route('user.produksi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
                    <td class="px-4 py-2">Grade {{ $produksi->kualitas }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('user.produksi.show', $produksi) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
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