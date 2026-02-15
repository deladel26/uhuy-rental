<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'no_ktp'
    ];

    public function dokumenPelanggan()
    {
        return $this->hasMany(DokumenPelanggan::class);
    }

    public function sewas()
    {
        return $this->hasMany(Sewa::class);
    }
}
