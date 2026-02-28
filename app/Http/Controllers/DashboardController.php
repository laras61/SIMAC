<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $adminMenus = [
            ['name' => 'Barang', 'route' => 'barang.index', 'desc' => 'Data master aset AC'],
            ['name' => 'User', 'route' => 'user.index', 'desc' => 'Kelola akun pengguna'],
            ['name' => 'Maintenance', 'route' => 'maintenance.index', 'desc' => 'Jadwal dan progres maintenance'],
            ['name' => 'Perbaikan', 'route' => 'perbaikan.index', 'desc' => 'Riwayat tindakan perbaikan'],
            ['name' => 'Reminder', 'route' => 'remainder.index', 'desc' => 'Pengingat email maintenance/perbaikan'],
        ];

        $maintenancePlans = [
            [
                'aset' => 'BMN-001 / Ruang Server',
                'last_date' => '2026-01-10',
                'next_due' => '2026-07-10',
                'teknisi' => 'Budi Teknisi',
                'pic' => 'Andi (GA)',
                'status' => 'Terjadwal',
            ],
            [
                'aset' => 'BMN-002 / Lobby Utama',
                'last_date' => '2025-12-05',
                'next_due' => '2026-06-05',
                'teknisi' => 'Raka AC Team',
                'pic' => 'Andi (GA)',
                'status' => 'Mendekati due',
            ],
            [
                'aset' => 'BMN-003 / Aula Pertemuan',
                'last_date' => '2025-08-20',
                'next_due' => '2026-02-20',
                'teknisi' => 'Budi Teknisi',
                'pic' => 'Andi (GA)',
                'status' => 'Lewat due',
            ],
        ];

        $repairHistories = [
            [
                'tanggal' => '2026-02-14',
                'aset' => 'BMN-003 / Aula',
                'jenis' => 'Ganti freon',
                'freon' => 'Ya',
                'part' => 'Valve service + pipa sambungan',
                'teknisi' => 'Budi Teknisi',
                'pic' => 'Andi (GA)',
            ],
            [
                'tanggal' => '2026-01-09',
                'aset' => 'BMN-001 / Server',
                'jenis' => 'Perbaikan unit indoor',
                'freon' => 'Tidak',
                'part' => 'Fan motor',
                'teknisi' => 'Raka AC Team',
                'pic' => 'Andi (GA)',
            ],
        ];

        $emailReminders = [
            [
                'tujuan' => 'pic.facility@company.com',
                'trigger' => 'H-7 jatuh tempo maintenance',
                'isi' => 'Pengingat jadwal maintenance 6 bulanan',
                'status' => 'Aktif',
            ],
            [
                'tujuan' => 'teknisi.vendor@company.com',
                'trigger' => 'Tiket perbaikan dibuat',
                'isi' => 'Notifikasi pekerjaan perbaikan baru',
                'status' => 'Aktif',
            ],
        ];

        return view('dashboard.index', [
            'adminMenus' => $adminMenus,
            'maintenancePlans' => $maintenancePlans,
            'repairHistories' => $repairHistories,
            'emailReminders' => $emailReminders,
        ]);
    }
}
