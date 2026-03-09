<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'role',
        'foto_profi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke Maintenance
    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'id_user', 'id_user');
    }

    // Relasi ke Perbaikan
    public function perbaikan()
    {
        return $this->hasMany(Perbaikan::class, 'id_user', 'id_user');
    }

    public function uploadFotoProfi($file, $path = 'users')
    {
        if ($file) {
            if ($this->foto_profi && Storage::disk('public')->exists($this->foto_profi)) {
                Storage::disk('public')->delete($this->foto_profi);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($path, $filename, 'public');
            $this->update(['foto_profi' => $filePath]);
            return $filePath;
        }
        return null;
    }

    public function deleteFotoProfi()
    {
        if ($this->foto_profi && Storage::disk('public')->exists($this->foto_profi)) {
            Storage::disk('public')->delete($this->foto_profi);
            $this->update(['foto_profi' => null]);
        }
    }
}
