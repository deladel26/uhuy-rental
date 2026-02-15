<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor',
        'merk',
        'tahun',
        'warna',
        'harga_sewa',
        'status',
        'kondisi',
    ];

    public function sewas()
    {
        return $this->hasMany(Sewa::class);
    }
}
