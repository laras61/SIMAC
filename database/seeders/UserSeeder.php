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
        ]);

        // User Teknisi
        User::create([
            'nama' => 'Budi Teknisi',
            'email' => 'budi@simac.com',
            'password' => Hash::make('teknisi123'),
            'no_hp' => '089876543210',
        ]);

        // User Staff
        User::create([
            'nama' => 'Siti Staff',
            'email' => 'siti@simac.com',
            'password' => Hash::make('staff123'),
            'no_hp' => '085678901234',
        ]);
    }
}
