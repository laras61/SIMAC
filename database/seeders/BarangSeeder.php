<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'kode_bmn' => 'BMN-001',
                'merk' => 'Daikin',
                'serial_number' => 'DK12345678',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2023-01-15',
                'tgl_instalasi' => '2023-01-20',
                'lokasi' => 'LAB A',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-002',
                'merk' => 'Panasonic',
                'serial_number' => 'PN98765432',
                'tipe_ac' => 'Cassette 2PK',
                'tgl_beli' => '2022-06-10',
                'tgl_instalasi' => '2022-06-15',
                'lokasi' => 'LAB B',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-003',
                'merk' => 'LG',
                'serial_number' => 'LG11223344',
                'tipe_ac' => 'Standing Floor 5PK',
                'tgl_beli' => '2021-11-05',
                'tgl_instalasi' => '2021-11-10',
                'lokasi' => 'RUANG DOSEN',
                'status' => 'rusak',
            ],

            // Tambahan otomatis sesuai permintaan: Split Wall untuk LAB C-F
            [
                'kode_bmn' => 'BMN-004',
                'merk' => 'LG',
                'serial_number' => 'LG-LABC-001',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-01-10',
                'tgl_instalasi' => '2024-01-15',
                'lokasi' => 'LAB C',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-005',
                'merk' => 'Samsung',
                'serial_number' => 'SM-LABC-002',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-01-12',
                'tgl_instalasi' => '2024-01-16',
                'lokasi' => 'LAB C',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-006',
                'merk' => 'Midea',
                'serial_number' => 'MD-LABD-001',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-01-20',
                'tgl_instalasi' => '2024-01-25',
                'lokasi' => 'LAB D',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-007',
                'merk' => 'Panasonic',
                'serial_number' => 'PN-LABD-002',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-01-22',
                'tgl_instalasi' => '2024-01-26',
                'lokasi' => 'LAB D',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-008',
                'merk' => 'Samsung',
                'serial_number' => 'SM-LABE-001',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-02-02',
                'tgl_instalasi' => '2024-02-06',
                'lokasi' => 'LAB E',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-009',
                'merk' => 'LG',
                'serial_number' => 'LG-LABE-002',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-02-03',
                'tgl_instalasi' => '2024-02-07',
                'lokasi' => 'LAB E',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-010',
                'merk' => 'Panasonic',
                'serial_number' => 'PN-LABF-001',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-02-10',
                'tgl_instalasi' => '2024-02-14',
                'lokasi' => 'LAB F',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-011',
                'merk' => 'Midea',
                'serial_number' => 'MD-LABF-002',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-02-12',
                'tgl_instalasi' => '2024-02-16',
                'lokasi' => 'LAB F',
                'status' => 'aktif',
            ],
            [
                'kode_bmn' => 'BMN-012',
                'merk' => 'Samsung',
                'serial_number' => 'SM-LABF-003',
                'tipe_ac' => 'Split Wall 1PK',
                'tgl_beli' => '2024-02-15',
                'tgl_instalasi' => '2024-02-19',
                'lokasi' => 'LAB F',
                'status' => 'aktif',
            ],
        ];

        foreach ($items as $item) {
            Barang::updateOrCreate(
                ['kode_bmn' => $item['kode_bmn']],
                $item
            );
        }
    }
}
