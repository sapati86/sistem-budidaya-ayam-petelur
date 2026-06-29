@extends('layouts.admin')

@section('title', 'Tambah Produksi Telur')
@section('header', 'Tambah Data Produksi Telur')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.produksi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
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
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Produksi (butir) *</label>
                <input type="number" name="jumlah_produksi" value="{{ old('jumlah_produksi') }}" 
                       class="w-full border rounded px-3 py-2 @error('jumlah_produksi') border-red-500 @enderror">
                @error('jumlah_produksi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Rusak (butir)</label>
                <input type="number" name="jumlah_rusak" value="{{ old('jumlah_rusak', 0) }}" 
                       class="w-full border rounded px-3 py-2 @error('jumlah_rusak') border-red-500 @enderror">
                @error('jumlah_rusak')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Kualitas *</label>
                <select name="kualitas" class="w-full border rounded px-3 py-2 @error('kualitas') border-red-500 @enderror">
                    <option value="A" {{ old('kualitas') == 'A' ? 'selected' : '' }}>Grade A (Besar)</option>
                    <option value="B" {{ old('kualitas') == 'B' ? 'selected' : '' }}>Grade B (Sedang)</option>
                    <option value="C" {{ old('kualitas') == 'C' ? 'selected' : '' }}>Grade C (Kecil)</option>
                </select>
                @error('kualitas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Berat Rata-rata (gram)</label>
                <input type="number" name="berat_rata_rata" value="{{ old('berat_rata_rata') }}" step="0.01"
                       class="w-full border rounded px-3 py-2 @error('berat_rata_rata') border-red-500 @enderror">
                @error('berat_rata_rata')
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
            <a href="{{ route('admin.produksi.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection