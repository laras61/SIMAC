<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maintenance;
use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data barang dan user pertama
        $barang1 = Barang::where('kode_bmn', 'BMN-001')->first();
        $barang2 = Barang::where('kode_bmn', 'BMN-002')->first();
        $userTeknisi = User::where('email', 'budi@simac.com')->first();
        
        if (!$barang1 || !$userTeknisi) {
            return;
        }

        // Maintenance Terjadwal
        Maintenance::create([
            'id_ac' => $barang1->id_ac,
            'id_user' => $userTeknisi->id_user,
            'tanggal_jadwal' => Carbon::now()->addMonths(1),
            'jenis' => 'preventive',
            'catatan' => 'Jadwal rutin 3 bulanan',
            'status' => 'pending',
        ]);

        // Maintenance Selesai
        Maintenance::create([
            'id_ac' => $barang1->id_ac,
            'id_user' => $userTeknisi->id_user,
            'tanggal_jadwal' => Carbon::now()->subMonths(3),
            'tanggal_dikerjakan' => Carbon::now()->subMonths(3)->addDays(1),
            'jenis' => 'preventive',
            'catatan' => 'Pembersihan filter dan cek freon',
            'status' => 'selesai',
        ]);

        if ($barang2) {
             // Maintenance Corrective
            Maintenance::create([
                'id_ac' => $barang2->id_ac,
                'id_user' => $userTeknisi->id_user,
                'tanggal_jadwal' => Carbon::now()->subDays(5),
                'tanggal_dikerjakan' => Carbon::now()->subDays(4),
                'jenis' => 'corrective',
                'catatan' => 'Perbaikan kebocoran pipa',
                'status' => 'selesai',
            ]);
        }
    }
}
