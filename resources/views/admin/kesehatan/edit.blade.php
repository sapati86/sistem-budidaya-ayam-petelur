@extends('layouts.admin')

@section('title', 'Edit Kandang')
@section('header', 'Edit Kandang')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.kandang.update', $kandang) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kode Kandang *</label>
                <input type="text" name="kode_kandang" value="{{ old('kode_kandang', $kandang->kode_kandang) }}" 
                       class="w-full border rounded px-3 py-2 @error('kode_kandang') border-red-500 @enderror">
                @error('kode_kandang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Nama Kandang *</label>
                <input type="text" name="nama" value="{{ old('nama', $kandang->nama) }}" 
                       class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Kapasitas *</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas', $kandang->kapasitas) }}" 
                       class="w-full border rounded px-3 py-2 @error('kapasitas') border-red-500 @enderror">
                @error('kapasitas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Status *</label>
                <select name="status" class="w-full border rounded px-3 py-2 @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', $kandang->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $kandang->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="perawatan" {{ old('status', $kandang->status) == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Lokasi *</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $kandang->lokasi) }}" 
                       class="w-full border rounded px-3 py-2 @error('lokasi') border-red-500 @enderror">
                @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $kandang->deskripsi) }}</textarea>
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Foto</label>
                @if($kandang->foto)
                    <div class="mb-2">
                        <img src="{{ $kandang->foto_url }}" class="h-20 w-20 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" 
                       class="w-full border rounded px-3 py-2 @error('foto') border-red-500 @enderror">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.kandang.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
@endsection