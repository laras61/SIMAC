<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remainder extends Model
{
    use HasFactory;

    protected $table = 'tbl_remainder';
    protected $primaryKey = 'id_remainder';

    protected $fillable = [
        'id_ac',
        'tanggal_kirim',
        'jenis',
        'email_tujuan',
        'status_kirim',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_ac', 'id_ac');
    }
}
