<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AyamSeeder extends Seeder
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
            $this->command->warn('⚠️  Tidak ada kandang aktif. Jalankan KandangSeeder terlebih dahulu!');
            return;
        }

        $ayams = [];

        // Data ayam untuk setiap kandang
        foreach ($kandangs as $index => $kandang) {
            $jenisOptions = ['pullet', 'layer', 'pejantan'];
            $statusOptions = ['sehat', 'sehat', 'sehat', 'sakit']; // 3 sehat, 1 sakit

            for ($i = 1; $i <= 15; $i++) {
                $jenis = $jenisOptions[array_rand($jenisOptions)];
                $status = $statusOptions[array_rand($statusOptions)];
                $umur = $jenis == 'pullet' ? rand(30, 90) : ($jenis == 'layer' ? rand(120, 365) : rand(180, 730));
                
                $ayams[] = [
                    'kandang_id' => $kandang->id,
                    'kode_ayam' => 'AYM-' . str_pad($kandang->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'jenis' => $jenis,
                    'umur_hari' => $umur,
                    'status_kesehatan' => $status,
                    'tanggal_masuk' => now()->subDays($umur)->format('Y-m-d'),
                    'tanggal_produksi' => $jenis == 'layer' ? now()->subDays(rand(10, 60))->format('Y-m-d') : null,
                    'produksi_telur_per_minggu' => $jenis == 'layer' ? rand(3, 7) : 0,
                    'keterangan' => 'Ayam ' . $jenis . ' dari kandang ' . $kandang->nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert batch
        foreach (array_chunk($ayams, 50) as $chunk) {
            Ayam::insert($chunk);
        }

        // Update jumlah ayam aktif di kandang
        foreach ($kandangs as $kandang) {
            $jumlahAyam = Ayam::where('kandang_id', $kandang->id)
                ->where('status_kesehatan', '!=', 'mati')
                ->count();
            $kandang->update(['jumlah_ayam_aktif' => $jumlahAyam]);
        }

        $this->command->info('✅ ' . count($ayams) . ' data ayam berhasil dibuat!');
        $this->command->info('📊 Jumlah ayam aktif di kandang telah diperbarui.');
    }
}