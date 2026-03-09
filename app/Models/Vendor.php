<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'tbl_vendor';
    protected $primaryKey = 'id_vendor';

    protected $fillable = [
        'nama_vendor',
        'email',
        'no_hp',
        'alamat',
        'pic_nama',
        'pic_no_hp',
        'status',
        'catatan',
    ];
}
