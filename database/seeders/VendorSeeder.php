<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@simac.com')->first();
        $teknisi = \App\Models\User::where('email', 'budi@simac.com')->first();
        $staff = \App\Models\User::where('email', 'siti@simac.com')->first();

        Vendor::updateOrCreate(
            ['email' => 'vendor.sejuk@simac.com'],
            [
            'nama_vendor' => 'PT Sejuk Sentosa',
            'no_hp' => '081200000001',
            'alamat' => 'Jakarta',
            'id_user' => optional($admin)->id_user,
            'layanan' => 'perbaikan',
            'status' => 'aktif',
            'catatan' => 'Spesialis AC split dan cassette',
        ]);

        Vendor::updateOrCreate(
            ['email' => 'vendor.dingin@simac.com'],
            [
            'nama_vendor' => 'CV Dingin Jaya',
            'no_hp' => '081200000002',
            'alamat' => 'Bogor',
            'id_user' => optional($teknisi)->id_user,
            'layanan' => 'perbaikan',
            'status' => 'aktif',
            'catatan' => null,
        ]);

        Vendor::updateOrCreate(
            ['email' => 'vendor.service@simac.com'],
            [
            'nama_vendor' => 'UD Service Mandiri',
            'no_hp' => '081200000003',
            'alamat' => 'Depok',
            'id_user' => optional($staff)->id_user,
            'layanan' => 'perbaikan',
            'status' => 'nonaktif',
            'catatan' => 'Tidak menerima panggilan luar kota',
        ]);
    }
}
