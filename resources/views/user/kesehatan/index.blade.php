@extends('layouts.user')

@section('title', 'Data Kesehatan Ayam')
@section('header', 'Data Kesehatan Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Kesehatan</h3>
        <a href="{{ route('user.kesehatan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i> Tambah Data Kesehatan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Ayam</th>
                    <th class="px-4 py-2 text-left">Penyakit</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kesehatans as $kesehatan)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $kesehatan->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $kesehatan->ayam->kode_ayam ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $kesehatan->jenis_penyakit }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs rounded 
                            @if($kesehatan->status == 'sembuh') bg-green-100 text-green-800
                            @elseif($kesehatan->status == 'perawatan') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $kesehatan->status_label ?? $kesehatan->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('user.kesehatan.show', $kesehatan) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data kesehatan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $kesehatans->links() }}
    </div>
</div>
@endsection