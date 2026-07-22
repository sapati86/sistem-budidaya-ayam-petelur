<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsumsiPakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandang_id',
        'pakan_id',
        'tanggal',
        'jumlah',
        'satuan',
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

    public function pakan()
    {
        return $this->belongsTo(Pakan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}