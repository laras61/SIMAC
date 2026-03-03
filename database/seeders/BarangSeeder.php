<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data 1
        Barang::create([
            'kode_bmn' => 'BMN-001',
            'merk' => 'Daikin',
            'serial_number' => 'DK12345678',
            'tipe_ac' => 'Split Wall 1PK',
            'tgl_beli' => '2023-01-15',
            'tgl_instalasi' => '2023-01-20',
            'lokasi' => 'LAB A',
            'status' => 'aktif',
        ]);

        // Contoh data 2
        Barang::create([
            'kode_bmn' => 'BMN-002',
            'merk' => 'Panasonic',
            'serial_number' => 'PN98765432',
            'tipe_ac' => 'Cassette 2PK',
            'tgl_beli' => '2022-06-10',
            'tgl_instalasi' => '2022-06-15',
            'lokasi' => 'LAB B',
            'status' => 'aktif',
        ]);

        // Contoh data 3
        Barang::create([
            'kode_bmn' => 'BMN-003',
            'merk' => 'LG',
            'serial_number' => 'LG11223344',
            'tipe_ac' => 'Standing Floor 5PK',
            'tgl_beli' => '2021-11-05',
            'tgl_instalasi' => '2021-11-10',
            'lokasi' => 'RUANG DOSEN',
            'status' => 'rusak',
        ]);
    }
}
