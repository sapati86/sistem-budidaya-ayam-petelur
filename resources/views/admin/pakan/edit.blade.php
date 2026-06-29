@extends('layouts.admin')

@section('title', 'Edit Pakan')
@section('header', 'Edit Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.pakan.update', $pakan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kode Pakan *</label>
                <input type="text" name="kode_pakan" value="{{ old('kode_pakan', $pakan->kode_pakan) }}" 
                       class="w-full border rounded px-3 py-2 @error('kode_pakan') border-red-500 @enderror">
                @error('kode_pakan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Nama Pakan *</label>
                <input type="text" name="nama" value="{{ old('nama', $pakan->nama) }}" 
                       class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jenis *</label>
                <select name="jenis" class="w-full border rounded px-3 py-2 @error('jenis') border-red-500 @enderror">
                    <option value="konsentrat" {{ old('jenis', $pakan->jenis) == 'konsentrat' ? 'selected' : '' }}>Konsentrat</option>
                    <option value="jagung" {{ old('jenis', $pakan->jenis) == 'jagung' ? 'selected' : '' }}>Jagung</option>
                    <option value="dedak" {{ old('jenis', $pakan->jenis) == 'dedak' ? 'selected' : '' }}>Dedak</option>
                    <option value="premix" {{ old('jenis', $pakan->jenis) == 'premix' ? 'selected' : '' }}>Premix</option>
                    <option value="lainnya" {{ old('jenis', $pakan->jenis) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Satuan *</label>
                <input type="text" name="satuan" value="{{ old('satuan', $pakan->satuan) }}" 
                       class="w-full border rounded px-3 py-2 @error('satuan') border-red-500 @enderror">
                @error('satuan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Stok *</label>
                <input type="number" name="stok" value="{{ old('stok', $pakan->stok) }}" 
                       class="w-full border rounded px-3 py-2 @error('stok') border-red-500 @enderror">
                @error('stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Stok Minimal *</label>
                <input type="number" name="stok_minimal" value="{{ old('stok_minimal', $pakan->stok_minimal) }}" 
                       class="w-full border rounded px-3 py-2 @error('stok_minimal') border-red-500 @enderror">
                @error('stok_minimal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Harga Satuan (Rp) *</label>
                <input type="number" name="harga_satuan" value="{{ old('harga_satuan', $pakan->harga_satuan) }}" step="0.01"
                       class="w-full border rounded px-3 py-2 @error('harga_satuan') border-red-500 @enderror">
                @error('harga_satuan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Kadaluarsa *</label>
                <input type="date" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $pakan->tanggal_kadaluarsa->format('Y-m-d')) }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal_kadaluarsa') border-red-500 @enderror">
                @error('tanggal_kadaluarsa')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ old('keterangan', $pakan->keterangan) }}</textarea>
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Foto</label>
                @if($pakan->foto)
                    <div class="mb-2">
                        <img src="{{ $pakan->foto_url }}" class="h-20 w-20 object-cover rounded">
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
            <a href="{{ route('admin.pakan.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
@endsection