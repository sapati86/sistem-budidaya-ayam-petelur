@extends('layouts.user')

@section('title', 'Tambah Produksi')
@section('header', 'Tambah Produksi Telur')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('user.produksi.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kandang *</label>
                <select name="kandang_id" class="w-full border rounded px-3 py-2">
                    @foreach($kandangs as $kandang)
                        <option value="{{ $kandang->id }}">{{ $kandang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Produksi *</label>
                <input type="number" name="jumlah_produksi" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jumlah Rusak</label>
                <input type="number" name="jumlah_rusak" value="0" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kualitas *</label>
                <select name="kualitas" class="w-full border rounded px-3 py-2">
                    <option value="A">Grade A</option>
                    <option value="B">Grade B</option>
                    <option value="C">Grade C</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Berat Rata-rata (gram)</label>
                <input type="number" name="berat_rata_rata" step="0.01" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('user.produksi.index') }}" class="px-4 py-2 bg-gray-300 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection