@extends('layouts.admin')

@section('title', 'Tambah Data Kesehatan')
@section('header', 'Tambah Data Kesehatan Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.kesehatan.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Ayam *</label>
                <select name="ayam_id" class="w-full border rounded px-3 py-2 @error('ayam_id') border-red-500 @enderror">
                    <option value="">Pilih Ayam</option>
                    @foreach($ayams as $ayam)
                        <option value="{{ $ayam->id }}" {{ old('ayam_id', $ayam_id ?? '') == $ayam->id ? 'selected' : '' }}>
                            {{ $ayam->kode_ayam }} ({{ $ayam->jenis_label }}) - {{ $ayam->status_kesehatan_label }}
                        </option>
                    @endforeach
                </select>
                @error('ayam_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Penyakit *</label>
                <input type="text" name="jenis_penyakit" value="{{ old('jenis_penyakit') }}" 
                       class="w-full border rounded px-3 py-2 @error('jenis_penyakit') border-red-500 @enderror">
                @error('jenis_penyakit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Status *</label>
                <select name="status" class="w-full border rounded px-3 py-2 @error('status') border-red-500 @enderror">
                    <option value="perawatan" {{ old('status') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                    <option value="sembuh" {{ old('status') == 'sembuh' ? 'selected' : '' }}>Sembuh</option>
                    <option value="mati" {{ old('status') == 'mati' ? 'selected' : '' }}>Mati</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Sembuh</label>
                <input type="date" name="tanggal_sembuh" value="{{ old('tanggal_sembuh') }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal_sembuh') border-red-500 @enderror">
                @error('tanggal_sembuh')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Gejala *</label>
                <textarea name="gejala" rows="3" class="w-full border rounded px-3 py-2 @error('gejala') border-red-500 @enderror">{{ old('gejala') }}</textarea>
                @error('gejala')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Tindakan *</label>
                <textarea name="tindakan" rows="3" class="w-full border rounded px-3 py-2 @error('tindakan') border-red-500 @enderror">{{ old('tindakan') }}</textarea>
                @error('tindakan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.kesehatan.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection