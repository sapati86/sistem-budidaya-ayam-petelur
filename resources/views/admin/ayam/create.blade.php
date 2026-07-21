@extends('layouts.admin')

@section('title', 'Tambah Ayam')
@section('header', 'Tambah Data Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.ayam.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kode Ayam *</label>
                <input type="text" name="kode_ayam" value="{{ old('kode_ayam') }}" 
                       class="w-full border rounded px-3 py-2 @error('kode_ayam') border-red-500 @enderror">
                @error('kode_ayam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Kandang *</label>
                <select name="kandang_id" class="w-full border rounded px-3 py-2 @error('kandang_id') border-red-500 @enderror">
                    <option value="">Pilih Kandang</option>
                    @foreach($kandangs as $kandang)
                        <option value="{{ $kandang->id }}" {{ old('kandang_id') == $kandang->id ? 'selected' : '' }}>
                            {{ $kandang->nama }} ({{ $kandang->kode_kandang }})
                        </option>
                    @endforeach
                </select>
                @error('kandang_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jenis *</label>
                <select name="jenis" class="w-full border rounded px-3 py-2 @error('jenis') border-red-500 @enderror">
                    <option value="pullet" {{ old('jenis') == 'pullet' ? 'selected' : '' }}>Pullet (Muda)</option>
                    <option value="layer" {{ old('jenis') == 'layer' ? 'selected' : '' }}>Layer (Petelur)</option>
                    <option value="pejantan" {{ old('jenis') == 'pejantan' ? 'selected' : '' }}>Pejantan</option>
                </select>
                @error('jenis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Umur (hari) *</label>
                <input type="number" name="umur_hari" value="{{ old('umur_hari') }}" 
                       class="w-full border rounded px-3 py-2 @error('umur_hari') border-red-500 @enderror">
                @error('umur_hari')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Status Kesehatan *</label>
                <select name="status_kesehatan" class="w-full border rounded px-3 py-2 @error('status_kesehatan') border-red-500 @enderror">
                    <option value="sehat" {{ old('status_kesehatan') == 'sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="sakit" {{ old('status_kesehatan') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="mati" {{ old('status_kesehatan') == 'mati' ? 'selected' : '' }}>Mati</option>
                </select>
                @error('status_kesehatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Masuk *</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal_masuk') border-red-500 @enderror">
                @error('tanggal_masuk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Produksi</label>
                <input type="date" name="tanggal_produksi" value="{{ old('tanggal_produksi') }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal_produksi') border-red-500 @enderror">
                @error('tanggal_produksi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Produksi Telur/Minggu</label>
                <input type="number" name="produksi_telur_per_minggu" value="{{ old('produksi_telur_per_minggu', 0) }}" 
                       class="w-full border rounded px-3 py-2 @error('produksi_telur_per_minggu') border-red-500 @enderror">
                @error('produksi_telur_per_minggu')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ old('keterangan') }}</textarea>
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Foto</label>
                <input type="file" name="foto" accept="image/*" 
                       class="w-full border rounded px-3 py-2 @error('foto') border-red-500 @enderror">
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.ayam.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection