<?php

namespace Database\Seeders;

use App\Models\Pakan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PakanSeeder extends Seeder
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

        $pakans = [
            [
                'kode_pakan' => 'PKN-001',
                'nama' => 'Pakan Layer Starter',
                'jenis' => 'konsentrat',
                'stok' => 500,
                'satuan' => 'kg',
                'harga_satuan' => 8500,
                'tanggal_kadaluarsa' => now()->addMonths(6),
                'stok_minimal' => 50,
                'keterangan' => 'Pakan untuk ayam layer usia 0-6 minggu',
                'created_by' => $admin->id,
            ],
            [
                'kode_pakan' => 'PKN-002',
                'nama' => 'Pakan Layer Grower',
                'jenis' => 'konsentrat',
                'stok' => 300,
                'satuan' => 'kg',
                'harga_satuan' => 8200,
                'tanggal_kadaluarsa' => now()->addMonths(5),
                'stok_minimal' => 40,
                'keterangan' => 'Pakan untuk ayam layer usia 7-18 minggu',
                'created_by' => $admin->id,
            ],
            [
                'kode_pakan' => 'PKN-003',
                'nama' => 'Pakan Layer Layer',
                'jenis' => 'konsentrat',
                'stok' => 1000,
                'satuan' => 'kg',
                'harga_satuan' => 7800,
                'tanggal_kadaluarsa' => now()->addMonths(4),
                'stok_minimal' => 100,
                'keterangan' => 'Pakan untuk ayam layer masa produksi',
                'created_by' => $admin->id,
            ],
            [
                'kode_pakan' => 'PKN-004',
                'nama' => 'Jagung Giling',
                'jenis' => 'jagung',
                'stok' => 200,
                'satuan' => 'kg',
                'harga_satuan' => 5500,
                'tanggal_kadaluarsa' => now()->addMonths(3),
                'stok_minimal' => 30,
                'keterangan' => 'Jagung giling untuk campuran pakan',
                'created_by' => $admin->id,
            ],
            [
                'kode_pakan' => 'PKN-005',
                'nama' => 'Dedak Halus',
                'jenis' => 'dedak',
                'stok' => 150,
                'satuan' => 'kg',
                'harga_satuan' => 4500,
                'tanggal_kadaluarsa' => now()->addMonths(2),
                'stok_minimal' => 25,
                'keterangan' => 'Dedak halus untuk campuran pakan',
                'created_by' => $admin->id,
            ],
            [
                'kode_pakan' => 'PKN-006',
                'nama' => 'Premix Vitamin',
                'jenis' => 'premix',
                'stok' => 50,
                'satuan' => 'kg',
                'harga_satuan' => 15000,
                'tanggal_kadaluarsa' => now()->addMonths(8),
                'stok_minimal' => 10,
                'keterangan' => 'Premix vitamin untuk meningkatkan produksi telur',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($pakans as $pakan) {
            Pakan::create($pakan);
        }

        $this->command->info('✅ ' . count($pakans) . ' data pakan berhasil dibuat!');
    }
}