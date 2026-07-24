@extends('layouts.user')

@section('title', 'Tambah Kesehatan')
@section('header', 'Tambah Data Kesehatan Ayam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('user.kesehatan.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Ayam *</label>
                <select name="ayam_id" class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Ayam</option>
                    @foreach($ayams as $ayam)
                        <option value="{{ $ayam->id }}">{{ $ayam->kode_ayam }} ({{ $ayam->jenis_label }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Penyakit *</label>
                <input type="text" name="jenis_penyakit" class="w-full border rounded px-3 py-2" placeholder="Flu Burung">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status *</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="perawatan">Perawatan</option>
                    <option value="sembuh">Sembuh</option>
                    <option value="mati">Mati</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Sembuh</label>
                <input type="date" name="tanggal_sembuh" class="w-full border rounded px-3 py-2">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Gejala *</label>
                <textarea name="gejala" rows="3" class="w-full border rounded px-3 py-2" placeholder="Deskripsikan gejala..."></textarea>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Tindakan *</label>
                <textarea name="tindakan" rows="3" class="w-full border rounded px-3 py-2" placeholder="Tindakan yang dilakukan..."></textarea>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2"></textarea>
            </div>
        </div>
        <div class="mt-4 flex justify-end gap-2">
            <a href="{{ route('user.kesehatan.index') }}" class="px-4 py-2 bg-gray-300 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection