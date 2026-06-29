<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kandang',
        'nama',
        'kapasitas',
        'jumlah_ayam_aktif',
        'lokasi',
        'status',
        'deskripsi',
        'foto',
        'created_by'
    ];

    // Relasi dengan User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan Ayam
    public function ayams()
    {
        return $this->hasMany(Ayam::class);
    }

    // Relasi dengan Produksi Telur
    public function produksiTelurs()
    {
        return $this->hasMany(ProduksiTelur::class);
    }

    // Relasi dengan Konsumsi Pakan
    public function konsumsiPakans()
    {
        return $this->hasMany(KonsumsiPakan::class);
    }

    // Accessor untuk status
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'perawatan' => 'Perawatan',
            default => 'Tidak Diketahui'
        };
    }

    // Accessor untuk foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/kandang/' . $this->foto);
        }
        return asset('images/default-kandang.jpg');
    }
}