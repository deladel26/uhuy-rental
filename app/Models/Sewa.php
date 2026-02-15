<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'motor_id',
        'user_id',
        'pelanggan_id',
        'tanggal_sewa',
        'tanggal_kembali_rencana',
        'tanggal_kembali_real',
        'harga_per_hari',
        'total_harga',
        'denda',
        'status',
        'status_pembayaran',
        'metode_bayar'
    ];

    protected $casts = [
        'tanggal_sewa' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_real' => 'date',
    ];

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function DokumenPelanggan()
    {
        return $this->hasMany(DokumenPelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
}
