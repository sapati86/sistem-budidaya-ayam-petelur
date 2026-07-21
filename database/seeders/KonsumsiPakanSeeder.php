<?php

namespace Database\Seeders;

use App\Models\Kandang;
use App\Models\KonsumsiPakan;
use App\Models\Pakan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KonsumsiPakanSeeder extends Seeder
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

        // Ambil kandang dan pakan
        $kandangs = Kandang::where('status', 'aktif')->get();
        $pakans = Pakan::all();

        if ($kandangs->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada kandang aktif. Buat kandang terlebih dahulu!');
            return;
        }

        if ($pakans->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada data pakan. Jalankan PakanSeeder terlebih dahulu!');
            return;
        }

        // Buat data konsumsi untuk 30 hari terakhir
        $startDate = now()->subDays(29);
        $endDate = now();

        $konsumsis = [];

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            foreach ($kandangs as $kandang) {
                // Pilih pakan random
                $pakan = $pakans->random();

                // Jumlah konsumsi antara 5-20 kg per hari per kandang
                $jumlah = rand(5, 20);

                // Kurangi stok pakan
                $pakan->decrement('stok', $jumlah);

                $konsumsis[] = [
                    'kandang_id' => $kandang->id,
                    'pakan_id' => $pakan->id,
                    'tanggal' => $date->copy()->format('Y-m-d'),
                    'jumlah' => $jumlah,
                    'satuan' => 'kg',
                    'keterangan' => 'Konsumsi pakan ' . $kandang->nama,
                    'created_by' => $admin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert batch
        foreach (array_chunk($konsumsis, 100) as $chunk) {
            KonsumsiPakan::insert($chunk);
        }

        $this->command->info('✅ ' . count($konsumsis) . ' data konsumsi pakan berhasil dibuat!');
        $this->command->info('📊 Stok pakan telah berkurang sesuai konsumsi.');
    }
}