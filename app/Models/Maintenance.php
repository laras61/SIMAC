<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    public function uploadFoto($file, $path = 'maintenance')
    {
        if ($file) {
            // Hapus foto lama jika ada
            if ($this->foto && file_exists(storage_path('app/public/' . $this->foto))) {
                unlink(storage_path('app/public/' . $this->foto));
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
