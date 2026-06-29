@extends('layouts.admin')

@section('title', 'Edit Konsumsi Pakan')
@section('header', 'Edit Data Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.konsumsi.update', $konsumsi) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kandang *</label>
                <select name="kandang_id" class="w-full border rounded px-3 py-2 @error('kandang_id') border-red-500 @enderror">
                    <option value="">Pilih Kandang</option>
                    @foreach($kandangs as $kandang)
                        <option value="{{ $kandang->id }}" {{ old('kandang_id', $konsumsi->kandang_id) == $kandang->id ? 'selected' : '' }}>
                            {{ $kandang->nama }} ({{ $kandang->kode_kandang }})
                        </option>
                    @endforeach
                </select>
                @error('kandang_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Pakan *</label>
                <select name="pakan_id" class="w-full border rounded px-3 py-2 @error('pakan_id') border-red-500 @enderror">
                    <option value="">Pilih Pakan</option>
                    @foreach($pakans as $pakan)
                        <option value="{{ $pakan->id }}" {{ old('pakan_id', $konsumsi->pakan_id) == $pakan->id ? 'selected' : '' }}>
                            {{ $pakan->nama }} (Stok: {{ $pakan->stok }} {{ $pakan->satuan }})
                        </option>
                    @endforeach
                </select>
                @error('pakan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $konsumsi->tanggal->format('Y-m-d')) }}" 
                       class="w-full border rounded px-3 py-2 @error('tanggal') border-red-500 @enderror">
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah *</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $konsumsi->jumlah) }}" 
                       class="w-full border rounded px-3 py-2 @error('jumlah') border-red-500 @enderror">
                @error('jumlah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Satuan *</label>
                <input type="text" name="satuan" value="{{ old('satuan', $konsumsi->satuan) }}" 
                       class="w-full border rounded px-3 py-2 @error('satuan') border-red-500 @enderror">
                @error('satuan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ old('keterangan', $konsumsi->keterangan) }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('admin.konsumsi.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</div>
@endsection