<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Remainder;
use App\Models\Barang;
use Carbon\Carbon;

class RemainderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang1 = Barang::where('kode_bmn', 'BMN-001')->first();
        $barang2 = Barang::where('kode_bmn', 'BMN-002')->first();

        if ($barang1) {
            Remainder::create([
                'id_ac' => $barang1->id_ac,
                'tanggal_kirim' => Carbon::now()->addDays(7),
                'jenis' => 'maintenance',
                'email_tujuan' => 'admin@simac.com',
                'status_kirim' => 'pending',
            ]);
        }

        if ($barang2) {
            Remainder::create([
                'id_ac' => $barang2->id_ac,
                'tanggal_kirim' => Carbon::now()->subDays(1),
                'jenis' => 'perbaikan',
                'email_tujuan' => 'teknisi@simac.com',
                'status_kirim' => 'sent',
            ]);
        }
    }
}
