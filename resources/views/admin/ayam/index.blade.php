@extends('layouts.admin')

@section('title', 'Data Ayam')
@section('header', 'Manajemen Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Ayam</h3>
        <a href="{{ route('admin.ayam.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i> Tambah Ayam
        </a>
    </div>
    
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
                    <td class="px-4 py-2">{{ $ayam->kode_ayam }}</td>
                    <td class="px-4 py-2">{{ $ayam->kandang->nama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $ayam->jenis_label }}</td>
                    <td class="px-4 py-2">{{ $ayam->umur_hari }} hari</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($ayam->status_kesehatan == 'sehat') bg-green-100 text-green-800
                            @elseif($ayam->status_kesehatan == 'sakit') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $ayam->status_kesehatan_label }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.ayam.show', $ayam) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.ayam.edit', $ayam) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.ayam.destroy', $ayam) }}" method="POST" class="inline">
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