<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandang_id',
        'kode_ayam',
        'jenis',
        'umur_hari',
        'status_kesehatan',
        'tanggal_masuk',
        'tanggal_produksi',
        'produksi_telur_per_minggu',
        'foto',
        'keterangan'
    ];

    // Relasi dengan Kandang
    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    // Relasi dengan Kesehatan
    public function kesehatanAyams()
    {
        return $this->hasMany(KesehatanAyam::class);
    }

    // Accessor untuk status kesehatan
    public function getStatusKesehatanLabelAttribute()
    {
        return match($this->status_kesehatan) {
            'sehat' => 'Sehat',
            'sakit' => 'Sakit',
            'mati' => 'Mati',
            default => 'Tidak Diketahui'
        };
    }

    public function getJenisLabelAttribute()
    {
        return match($this->jenis) {
            'pullet' => 'Pullet (Muda)',
            'layer' => 'Layer (Petelur)',
            'pejantan' => 'Pejantan',
            default => 'Tidak Diketahui'
        };
    }

    public function produksiTelurs()
    {
        return $this->hasMany(ProduksiTelur::class);
    }
}