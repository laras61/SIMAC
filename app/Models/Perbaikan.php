<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'foto',
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

    // Method untuk upload foto
    public function uploadFoto($file, $path = 'perbaikan')
    {
        if ($file) {
            // Hapus foto lama jika ada
            if ($this->foto && Storage::disk('public')->exists($this->foto)) {
                Storage::disk('public')->delete($this->foto);
            }
            
            // Simpan foto baru
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($path, $filename, 'public');
            
            // Update path di database
            $this->update(['foto' => $filePath]);
            
            return $filePath;
        }
        
        return null;
    }

    // Method untuk hapus foto
    public function deleteFoto()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            Storage::disk('public')->delete($this->foto);
            $this->update(['foto' => null]);
        }
    }
}
