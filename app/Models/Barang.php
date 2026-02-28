<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tbl_barang';
    protected $primaryKey = 'id_ac';
    
    protected $fillable = [
        'kode_bmn',
        'merk',
        'serial_number',
        'tipe_ac',
        'tgl_beli',
        'tgl_instalasi',
        'lokasi',
        'status',
    ];

    // Relasi ke Maintenance
    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'id_ac', 'id_ac');
    }

    // Relasi ke Perbaikan
    public function perbaikan()
    {
        return $this->hasMany(Perbaikan::class, 'id_ac', 'id_ac');
    }

    // Relasi ke Remainder
    public function remainder()
    {
        return $this->hasMany(Remainder::class, 'id_ac', 'id_ac');
    }
}
