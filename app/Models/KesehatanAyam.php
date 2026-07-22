<?php

namespace App\Models;


use App\Models\Ayam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesehatanAyam extends Model
{
    use HasFactory;

    protected $fillable = [
        'ayam_id',
        'tanggal',
        'jenis_penyakit',
        'gejala',
        'tindakan',
        'status',
        'tanggal_sembuh',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ayam()
    {
        return $this->belongsTo(Ayam::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'sembuh' => 'Sembuh',
            'perawatan' => 'Perawatan',
            'mati' => 'Mati',
            default => 'Tidak Diketahui'
        };
    }
}