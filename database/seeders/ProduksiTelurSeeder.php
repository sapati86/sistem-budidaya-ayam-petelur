<?php

namespace Database\Seeders;

use App\Models\Kandang;
use App\Models\ProduksiTelur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProduksiTelurSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan user admin ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@petelur.com'],
            [
                'name' => 'Admin Petelur',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Ambil kandang yang aktif
        $kandangs = Kandang::where('status', 'aktif')->get();

        if ($kandangs->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada kandang aktif. Buat kandang terlebih dahulu!');
            return;
        }

        // Buat data produksi untuk 30 hari terakhir
        $startDate = now()->subDays(29);
        $endDate = now();

        $kualitas = ['A', 'B', 'C'];
        $produksis = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            foreach ($kandangs as $kandang) {
                // Random produksi antara 50-150 butir per kandang per hari
                $jumlahProduksi = rand(50, 150);
                $jumlahRusak = rand(0, (int)($jumlahProduksi * 0.1)); // Maks 10% rusak
                $kualitasRand = $kualitas[array_rand($kualitas)];

                // Berat rata-rata berdasarkan kualitas
                $beratRataRata = match($kualitasRand) {
                    'A' => rand(62, 70) + rand(0, 99) / 100,
                    'B' => rand(55, 61) + rand(0, 99) / 100,
                    'C' => rand(45, 54) + rand(0, 99) / 100,
                };

                $produksis[] = [
                    'kandang_id' => $kandang->id,
                    'tanggal' => $date->copy()->format('Y-m-d'),
                    'jumlah_produksi' => $jumlahProduksi,
                    'jumlah_rusak' => $jumlahRusak,
                    'kualitas' => $kualitasRand,
                    'berat_rata_rata' => $beratRataRata,
                    'keterangan' => 'Produksi harian ' . $kandang->nama,
                    'created_by' => $admin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert batch untuk performa lebih baik
        foreach (array_chunk($produksis, 100) as $chunk) {
            ProduksiTelur::insert($chunk);
        }

        $this->command->info('✅ ' . count($produksis) . ' data produksi telur berhasil dibuat!');
    }
}