<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perbaikan;
use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;

class PerbaikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang1 = Barang::where('kode_bmn', 'BMN-001')->first();
        $barang3 = Barang::where('kode_bmn', 'BMN-003')->first();
        $userTeknisi = User::where('email', 'budi@simac.com')->first();
        
        if (!$userTeknisi) {
            return;
        }

        if ($barang1) {
            Perbaikan::create([
                'id_ac' => $barang1->id_ac,
                'tanggal_perbaikan' => Carbon::now()->subMonths(1),
                'jenis_perbaikan' => 'Ganti Kapasitor',
                'deskripsi' => 'Kapasitor fan outdoor lemah, diganti baru',
                'id_user' => $userTeknisi->id_user,
                'biaya' => 150000,
                'status' => 'selesai',
            ]);
        }

        if ($barang3) {
            Perbaikan::create([
                'id_ac' => $barang3->id_ac,
                'tanggal_perbaikan' => Carbon::now()->subWeeks(2),
                'jenis_perbaikan' => 'Isi Freon',
                'deskripsi' => 'Tekanan freon rendah, indikasi bocor halus',
                'id_user' => $userTeknisi->id_user,
                'biaya' => 350000,
                'status' => 'proses',
            ]);
        }
    }
}
