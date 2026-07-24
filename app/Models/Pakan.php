<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pakan',
        'nama',
        'jenis',
        'stok',
        'satuan',
        'harga_satuan',
        'tanggal_kadaluarsa',
        'stok_minimal',
        'foto',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function konsumsiPakans()
    {
        return $this->hasMany(KonsumsiPakan::class);
    }

    public function getJenisLabelAttribute()
    {
        return match($this->jenis) {
            'konsentrat' => 'Konsentrat',
            'jagung' => 'Jagung',
            'dedak' => 'Dedak',
            'premix' => 'Premix',
            'lainnya' => 'Lainnya',
            default => 'Tidak Diketahui'
        };
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/pakan/' . $this->foto);
        }
        return asset('images/default-pakan.jpg');
    }

    public function isStokMenipis()
    {
        return $this->stok <= $this->stok_minimal;
    }

    public function isKadaluarsa()
    {
        return $this->tanggal_kadaluarsa->isPast();
    }
}