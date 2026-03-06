<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    
class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'tbl_maintenance';
    protected $primaryKey = 'id_maintenance';

    protected $fillable = [
        'id_ac',
        'id_user',
        'id_vendor',
        'tanggal_jadwal',
        'tanggal_dikerjakan',
        'jenis',
        'catatan',
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
