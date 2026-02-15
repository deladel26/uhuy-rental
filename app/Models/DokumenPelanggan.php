<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPelanggan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pelanggan';

    public $timestamps = false;

    protected $fillable = [
        'pelanggan_id',
        'jenis_dokumen',
        'file_path',
        'uploaded_at'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
