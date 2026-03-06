<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $table = 'tbl_perbaikan';
    protected $primaryKey = 'id_perbaikan';

    protected $fillable = [
        'id_ac',
        'tanggal_perbaikan',
        'jenis_perbaikan',
        'deskripsi',
        'id_user',
        'id_vendor',
        'biaya',
        'status',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_ac', 'id_ac');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }
}
