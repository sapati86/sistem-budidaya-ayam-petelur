@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Total Kandang</div>
        <div class="text-2xl font-bold">{{ \App\Models\Kandang::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Total Ayam</div>
        <div class="text-2xl font-bold">{{ \App\Models\Ayam::count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Ayam Sehat</div>
        <div class="text-2xl font-bold text-green-600">{{ \App\Models\Ayam::where('status_kesehatan', 'sehat')->count() }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-gray-500 text-sm">Ayam Sakit</div>
        <div class="text-2xl font-bold text-red-600">{{ \App\Models\Ayam::where('status_kesehatan', 'sakit')->count() }}</div>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">Kandang Terbaru</h3>
        @foreach(\App\Models\Kandang::latest()->take(5)->get() as $kandang)
            <div class="flex justify-between items-center border-b py-2">
                <span>{{ $kandang->nama }}</span>
                <span class="text-sm text-gray-500">{{ $kandang->jumlah_ayam_aktif }} ayam</span>
            </div>
        @endforeach
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">Status Kesehatan</h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span>🟢 Sehat</span>
                <span>{{ \App\Models\Ayam::where('status_kesehatan', 'sehat')->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span>🟡 Sakit</span>
                <span>{{ \App\Models\Ayam::where('status_kesehatan', 'sakit')->count() }}</span>
            </div>
            <div class="flex justify-between">
                <span>🔴 Mati</span>
                <span>{{ \App\Models\Ayam::where('status_kesehatan', 'mati')->count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection