<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiTelur extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandang_id',
        'tanggal',
        'jumlah_produksi',
        'jumlah_rusak',
        'kualitas',
        'berat_rata_rata',
        'foto',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getKualitasLabelAttribute()
    {
        return match($this->kualitas) {
            'A' => 'Grade A (Besar)',
            'B' => 'Grade B (Sedang)',
            'C' => 'Grade C (Kecil)',
            default => 'Tidak Diketahui'
        };
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/produksi/' . $this->foto);
        }
        return asset('images/default-telur.jpg');
    }

    public function getTotalProduksiAttribute()
    {
        return $this->jumlah_produksi - $this->jumlah_rusak;
    }
}