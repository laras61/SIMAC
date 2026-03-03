<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Perbaikan;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('teknisi.dashboard');
        }

        $today = Carbon::today();
        $nearDueLimit = $today->copy()->addDays(30);

        $latestMaintenanceByAc = Maintenance::with('user:id_user,nama')
            ->whereNotNull('tanggal_dikerjakan')
            ->orderByDesc('tanggal_dikerjakan')
            ->orderByDesc('id_maintenance')
            ->get()
            ->unique('id_ac')
            ->keyBy('id_ac');

        $barangs = Barang::query()
            ->orderBy('kode_bmn')
            ->get();

        $maintenancePlans = $barangs->map(function (Barang $barang) use ($latestMaintenanceByAc, $today, $nearDueLimit) {
            $lastMaintenance = $latestMaintenanceByAc->get($barang->id_ac);
            $lastDateRaw = $lastMaintenance?->tanggal_dikerjakan ?: $barang->tgl_instalasi;
            $lastDate = Carbon::parse($lastDateRaw);
            $nextDue = $lastDate->copy()->addMonthsNoOverflow(6);

            if ($nextDue->lt($today)) {
                $statusDue = 'Lewat due';
            } elseif ($nextDue->lte($nearDueLimit)) {
                $statusDue = 'Mendekati due';
            } else {
                $statusDue = 'Terjadwal';
            }

            return [
                'aset' => $barang->kode_bmn . ' / ' . $barang->lokasi,
                'last_date' => $lastDate->format('Y-m-d'),
                'next_due' => $nextDue->format('Y-m-d'),
                'teknisi' => $lastMaintenance?->user?->nama ?? '-',
                'pic' => '-',
                'status' => $statusDue,
            ];
        })
            ->filter(function (array $plan) use ($nearDueLimit) {
                return Carbon::parse($plan['next_due'])->lte($nearDueLimit);
            })
            ->sortBy('next_due')
            ->values();

        $repairHistories = Perbaikan::with('barang:id_ac,kode_bmn,lokasi')
            ->orderByDesc('tanggal_perbaikan')
            ->orderByDesc('id_perbaikan')
            ->take(10)
            ->get()
            ->map(function (Perbaikan $perbaikan) {
                return [
                    'tanggal' => $perbaikan->tanggal_perbaikan,
                    'aset' => ($perbaikan->barang->kode_bmn ?? '-') . ' / ' . ($perbaikan->barang->lokasi ?? '-'),
                    'keterangan' => $perbaikan->jenis_perbaikan . (! empty($perbaikan->deskripsi) ? ' | ' . $perbaikan->deskripsi : ''),
                ];
            });

        $totalBarang = $barangs->count();
        $dueCount = $maintenancePlans->where('status', 'Lewat due')->count();
        $nearDueCount = $maintenancePlans->where('status', 'Mendekati due')->count();

        return view('dashboard.index', [
            'totalBarang' => $totalBarang,
            'dueCount' => $dueCount,
            'nearDueCount' => $nearDueCount,
            'maintenancePlans' => $maintenancePlans,
            'repairHistories' => $repairHistories,
        ]);
    }

    public function teknisi()
    {
        if (Auth::user()->role !== 'teknisi') {
            return redirect()->route('dashboard');
        }
        
        return view('teknisi_dashboard');
    }
}
