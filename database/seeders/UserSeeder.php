<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@simac.com',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'role' => 'admin',
        ]);

        // User Staff
        User::create([
            'nama' => 'Budi Staff',
            'email' => 'budi@simac.com',
            'password' => Hash::make('staff123'),
            'no_hp' => '089876543210',
            'role' => 'staff',
        ]);

        // User Staff 2
        User::create([
            'nama' => 'Siti Staff',
            'email' => 'siti@simac.com',
            'password' => Hash::make('staff123'),
            'no_hp' => '085678901234',
            'role' => 'staff',
        ]);
    }
}
