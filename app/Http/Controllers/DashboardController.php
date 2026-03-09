<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Perbaikan;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (in_array(Auth::user()->role, ['staff', 'pic', 'teknisi'])) {
            return redirect()->route('staff.dashboard');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $daysAhead = (int) $request->query('days', 30);
        $daysAhead = max(1, min($daysAhead, 365));

        $today = Carbon::today();
        $nearDueLimit = $today->copy()->addDays($daysAhead);

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
                'pic' => $lastMaintenance?->user?->nama ?? '-',
                'status' => $statusDue,
            ];
        })
            ->filter(function (array $plan) use ($nearDueLimit) {
                return Carbon::parse($plan['next_due'])->lte($nearDueLimit);
            })
            ->sortBy('next_due')
            ->values();

        $sevenDaysAgo = $today->copy()->subDays(7);

        $repairHistories = Perbaikan::with('barang:id_ac,kode_bmn,lokasi')
            ->whereBetween('tanggal_perbaikan', [$sevenDaysAgo->toDateString(), $today->toDateString()])
            ->orderByDesc('tanggal_perbaikan')
            ->orderByDesc('id_perbaikan')
            ->get()
            ->map(function (Perbaikan $perbaikan) {
                return [
                    'id_perbaikan' => $perbaikan->id_perbaikan,
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
            'daysAhead' => $daysAhead,
        ]);
    }

    public function teknisi()
    {
        return redirect()->route('staff.dashboard');
    }

    public function staff()
    {
        if (! in_array(Auth::user()->role, ['staff', 'pic', 'teknisi'])) {
            return redirect()->route('dashboard');
        }

        $userId = Auth::id();

        // Ambil jadwal maintenance yang ditugaskan ke user ini
        $myMaintenances = Maintenance::with('barang:id_ac,kode_bmn,lokasi')
            ->where('id_user', $userId)
            ->whereNull('tanggal_dikerjakan') // Hanya yang belum selesai
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();

        // Ambil riwayat perbaikan yang dilaporkan/ditangani oleh user ini
        $myRepairs = Perbaikan::with('barang:id_ac,kode_bmn,lokasi')
            ->where('id_user', $userId)
            ->orderByDesc('tanggal_perbaikan')
            ->take(5)
            ->get();
        
        return view('staff_dashboard', compact('myMaintenances', 'myRepairs'));
    }
}
