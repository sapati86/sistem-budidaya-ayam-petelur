<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\Kandang;
use Illuminate\Database\Seeder;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kandang
        $kandang1 = Kandang::create([
            'kode_kandang' => 'KDG-001',
            'nama' => 'Kandang A',
            'kapasitas' => 100,
            'jumlah_ayam_aktif' => 80,
            'lokasi' => 'Blok A, Gedung 1',
            'status' => 'aktif',
            'deskripsi' => 'Kandang untuk ayam layer',
            'created_by' => 1,
        ]);

        $kandang2 = Kandang::create([
            'kode_kandang' => 'KDG-002',
            'nama' => 'Kandang B',
            'kapasitas' => 80,
            'jumlah_ayam_aktif' => 50,
            'lokasi' => 'Blok B, Gedung 2',
            'status' => 'aktif',
            'deskripsi' => 'Kandang untuk ayam pullet',
            'created_by' => 1,
        ]);

        // Buat ayam di kandang 1
        for ($i = 1; $i <= 5; $i++) {
            Ayam::create([
                'kandang_id' => $kandang1->id,
                'kode_ayam' => 'AYM-00' . $i,
                'jenis' => 'layer',
                'umur_hari' => 120 + $i,
                'status_kesehatan' => $i % 3 == 0 ? 'sakit' : 'sehat',
                'tanggal_masuk' => now()->subDays(120),
                'tanggal_produksi' => now()->subDays(30),
                'produksi_telur_per_minggu' => 5,
                'keterangan' => 'Ayam sehat',
            ]);
        }
    }
}