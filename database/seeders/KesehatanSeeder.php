<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\KesehatanAyam;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KesehatanSeeder extends Seeder
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

        // Ambil ayam yang sehat atau sakit (bukan mati)
        $ayams = Ayam::where('status_kesehatan', '!=', 'mati')->get();

        if ($ayams->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada data ayam. Jalankan AyamSeeder terlebih dahulu!');
            return;
        }

        $penyakitList = [
            'Flu Burung (Avian Influenza)',
            'ND (Newcastle Disease)',
            'Snot (Coryza)',
            'CRD (Chronic Respiratory Disease)',
            'Pullorum',
            'Fowl Pox',
            'Marek\'s Disease',
            'Gumboro (IBD)',
            'Coccidiosis',
            'Ascariasis (Cacingan)',
        ];

        $gejalaList = [
            'Bersin-bersin, nafsu makan menurun',
            'Batuk, keluar lendir dari hidung',
            'Diare berwarna hijau/kuning',
            'Lesu, bulu kusut, sayap turun',
            'Kesulitan bernafas, napas berbunyi',
            'Pembengkakan pada mata dan wajah',
            'Produksi telur menurun drastis',
            'Kelumpuhan pada kaki dan sayap',
            'Kotoran berdarah',
            'Penurunan berat badan',
        ];

        $tindakanList = [
            'Pemberian antibiotik dan vitamin',
            'Isolasi kandang, pemberian obat',
            'Vaksinasi dan sanitasi kandang',
            'Pemberian multivitamin dan probiotik',
            'Terapi dengan obat tradisional',
            'Konsultasi dengan dokter hewan',
        ];

        $statusOptions = ['perawatan', 'perawatan', 'sembuh', 'sembuh']; // 2 perawatan, 2 sembuh

        $kesehatans = [];

        // Buat data kesehatan untuk 30% ayam
        $selectedAyams = $ayams->random(min($ayams->count(), (int)($ayams->count() * 0.3)));

        foreach ($selectedAyams as $ayam) {
            $penyakitIndex = array_rand($penyakitList);
            $status = $statusOptions[array_rand($statusOptions)];
            $tanggal = now()->subDays(rand(1, 60));

            // Update status kesehatan ayam jika sakit/mati
            if ($status == 'perawatan') {
                $ayam->update(['status_kesehatan' => 'sakit']);
            } elseif ($status == 'sembuh') {
                $ayam->update(['status_kesehatan' => 'sehat']);
            }

            $kesehatans[] = [
                'ayam_id' => $ayam->id,
                'tanggal' => $tanggal->format('Y-m-d'),
                'jenis_penyakit' => $penyakitList[$penyakitIndex],
                'gejala' => $gejalaList[$penyakitIndex],
                'tindakan' => $tindakanList[array_rand($tindakanList)],
                'status' => $status,
                'tanggal_sembuh' => $status == 'sembuh' ? now()->subDays(rand(1, 30))->format('Y-m-d') : null,
                'keterangan' => 'Penanganan penyakit ' . $penyakitList[$penyakitIndex],
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert batch
        foreach (array_chunk($kesehatans, 50) as $chunk) {
            KesehatanAyam::insert($chunk);
        }

        // Update status ayam yang mati (jika ada)
        $ayamMati = Ayam::whereHas('kesehatanAyams', function($query) {
            $query->where('status', 'mati');
        })->get();

        foreach ($ayamMati as $ayam) {
            $ayam->update(['status_kesehatan' => 'mati']);
        }

        $this->command->info('✅ ' . count($kesehatans) . ' data kesehatan ayam berhasil dibuat!');
    }
}