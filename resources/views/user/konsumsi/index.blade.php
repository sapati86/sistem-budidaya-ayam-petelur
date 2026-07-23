@extends('layouts.user')

@section('title', 'Data Konsumsi Pakan')
@section('header', 'Data Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Konsumsi</h3>
        <a href="{{ route('user.konsumsi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i> Tambah Konsumsi
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Kandang</th>
                    <th class="px-4 py-2 text-left">Pakan</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konsumsis as $konsumsi)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $konsumsi->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $konsumsi->kandang->nama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $konsumsi->pakan->nama ?? '-' }}</td>
                    <td class="px-4 py-2 font-semibold">{{ number_format($konsumsi->jumlah) }} {{ $konsumsi->satuan }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('user.konsumsi.show', $konsumsi) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data konsumsi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $konsumsis->links() }}
    </div>
</div>
@endsection