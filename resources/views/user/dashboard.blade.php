@extends('layouts.user')

@section('title', 'User Dashboard')
@section('header', 'Dashboard User')

@section('content')
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Total Kandang</div>
        <div class="text-2xl font-bold text-blue-600">{{ \App\Models\Kandang::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Total Ayam</div>
        <div class="text-2xl font-bold text-green-600">{{ \App\Models\Ayam::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Produksi Hari Ini</div>
        <div class="text-2xl font-bold text-yellow-600">
            {{ \App\Models\ProduksiTelur::whereDate('tanggal', today())->sum('jumlah_produksi') }}
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Ayam Sakit</div>
        <div class="text-2xl font-bold text-red-600">{{ \App\Models\Ayam::where('status_kesehatan', 'sakit')->count() }}</div>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-4">📋 Aktivitas Terbaru</h3>
        <ul class="space-y-2 text-sm">
            <li class="border-b pb-2">📝 Catat produksi hari ini</li>
            <li class="border-b pb-2">📦 Catat konsumsi pakan</li>
            <li class="border-b pb-2">❤️ Periksa kesehatan ayam</li>
        </ul>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-4">📊 Ringkasan</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between border-b pb-1">
                <span>Total Kandang Aktif</span>
                <span class="font-bold">{{ \App\Models\Kandang::where('status', 'aktif')->count() }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span>Total Ayam Sehat</span>
                <span class="font-bold text-green-600">{{ \App\Models\Ayam::where('status_kesehatan', 'sehat')->count() }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span>Total Ayam Sakit</span>
                <span class="font-bold text-red-600">{{ \App\Models\Ayam::where('status_kesehatan', 'sakit')->count() }}</span>
            </div>
            <div class="flex justify-between border-b pb-1">
                <span>Total Ayam Mati</span>
                <span class="font-bold text-gray-600">{{ \App\Models\Ayam::where('status_kesehatan', 'mati')->count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection