@extends('layouts.user')

@section('title', 'Tambah Konsumsi')
@section('header', 'Tambah Data Konsumsi Pakan')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('user.konsumsi.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kandang *</label>
                <select name="kandang_id" class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Kandang</option>
                    @foreach($kandangs as $kandang)
                        <option value="{{ $kandang->id }}">{{ $kandang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Pakan *</label>
                <select name="pakan_id" class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Pakan</option>
                    @foreach($pakans as $pakan)
                        <option value="{{ $pakan->id }}">{{ $pakan->nama }} (Stok: {{ $pakan->stok }} {{ $pakan->satuan }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah *</label>
                <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" placeholder="10">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Satuan *</label>
                <input type="text" name="satuan" value="kg" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('user.konsumsi.index') }}" class="px-4 py-2 bg-gray-300 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection