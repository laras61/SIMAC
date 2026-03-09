<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        Vendor::updateOrCreate(
            ['email' => 'vendor.sejuk@simac.com'],
            [
            'nama_vendor' => 'PT Sejuk Sentosa',
            'no_hp' => '081200000001',
            'alamat' => 'Jakarta',
            'pic_nama' => 'Bapak Andi',
            'pic_no_hp' => '081200000101',
            'status' => 'aktif',
            'catatan' => 'Spesialis AC split dan cassette',
        ]);

        Vendor::updateOrCreate(
            ['email' => 'vendor.dingin@simac.com'],
            [
            'nama_vendor' => 'CV Dingin Jaya',
            'no_hp' => '081200000002',
            'alamat' => 'Bogor',
            'pic_nama' => 'Ibu Rina',
            'pic_no_hp' => '081200000102',
            'status' => 'aktif',
            'catatan' => null,
        ]);

        Vendor::updateOrCreate(
            ['email' => 'vendor.service@simac.com'],
            [
            'nama_vendor' => 'UD Service Mandiri',
            'no_hp' => '081200000003',
            'alamat' => 'Depok',
            'pic_nama' => 'Mas Dedi',
            'pic_no_hp' => '081200000103',
            'status' => 'nonaktif',
            'catatan' => 'Tidak menerima panggilan luar kota',
        ]);
    }
}
