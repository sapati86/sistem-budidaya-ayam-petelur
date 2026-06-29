@extends('layouts.admin')

@section('title', 'Data Konsumsi Pakan')
@section('header', 'Manajemen Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-semibold">Daftar Konsumsi Pakan</h3>
            <p class="text-sm text-gray-500">Total konsumsi bulan ini: {{ number_format($totalKonsumsi) }} kg</p>
        </div>
        <a href="{{ route('admin.konsumsi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
                @forelse($konsumsi as $item)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $item->kandang->nama }}</td>
                    <td class="px-4 py-2">{{ $item->pakan->nama }}</td>
                    <td class="px-4 py-2 font-semibold">{{ number_format($item->jumlah) }} {{ $item->satuan }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.konsumsi.show', $item) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.konsumsi.edit', $item) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.konsumsi.destroy', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Yakin hapus? Stok pakan akan dikembalikan.')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data konsumsi pakan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $konsumsi->links() }}
    </div>
</div>
@endsection