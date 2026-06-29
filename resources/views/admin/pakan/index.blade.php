@extends('layouts.admin')

@section('title', 'Data Pakan')
@section('header', 'Manajemen Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-semibold">Daftar Pakan</h3>
            @if($stokMenipis->count() > 0)
                <p class="text-sm text-red-500 mt-1">
                    ⚠️ {{ $stokMenipis->count() }} pakan stok menipis!
                </p>
            @endif
        </div>
        <a href="{{ route('admin.pakan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i> Tambah Pakan
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-left">Stok</th>
                    <th class="px-4 py-2 text-left">Kadaluarsa</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pakans as $pakan)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $pakan->kode_pakan }}</td>
                    <td class="px-4 py-2">{{ $pakan->nama }}</td>
                    <td class="px-4 py-2">{{ $pakan->jenis_label }}</td>
                    <td class="px-4 py-2">
                        {{ $pakan->stok }} {{ $pakan->satuan }}
                        @if($pakan->isStokMenipis())
                            <span class="text-red-500 text-xs ml-1">⚠️</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        {{ $pakan->tanggal_kadaluarsa->format('d/m/Y') }}
                        @if($pakan->isKadaluarsa())
                            <span class="text-red-500 text-xs ml-1">(Expired)</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($pakan->isKadaluarsa())
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Kadaluarsa</span>
                        @elseif($pakan->isStokMenipis())
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">Stok Menipis</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Tersedia</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.pakan.show', $pakan) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.pakan.edit', $pakan) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.pakan.destroy', $pakan) }}" method="POST" class="inline">
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
                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pakan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $pakans->links() }}
    </div>
</div>
@endsection