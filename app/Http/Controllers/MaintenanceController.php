<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Jika staff/pic, arahkan ke view khusus staff
        if (in_array($user->role, ['staff', 'pic'])) {
            return $this->staffIndex();
        }

        $this->syncPreventiveMaintenanceSchedules();
        $this->promoteDueMaintenanceToProses();

        $search = trim((string) request('q', ''));
        $status = trim((string) request('status', ''));

        $itemsQuery = Maintenance::with(['barang', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('jenis', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('kode_bmn', 'like', '%' . $search . '%')
                                ->orWhere('merk', 'like', '%' . $search . '%')
                                ->orWhere('lokasi', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('nama', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            });

        $items = $itemsQuery
            ->orderByRaw("CASE WHEN status IN ('pending', 'proses') THEN 0 ELSE 1 END")
            ->orderByRaw('ABS(DATEDIFF(tanggal_jadwal, CURDATE())) ASC')
            ->orderBy('tanggal_jadwal')
            ->orderByDesc('id_maintenance')
            ->get();
        $listPic = User::query()
            ->where('role', 'staff')
            ->select('id_user', 'nama')
            ->orderBy('nama')
            ->get();

        $editItem = null;
        if (request()->filled('edit')) {
            $editItem = Maintenance::with(['barang', 'user'])->find(request('edit'));
        }

        return view('maintenance.index', compact('items', 'listPic', 'editItem', 'search', 'status'));
    }

    private function staffIndex()
    {
        $userId = auth()->id();
        $items = Maintenance::with(['barang'])
            ->where('id_user', $userId)
            ->orderBy('tanggal_jadwal', 'asc')
            ->get();
            
        return view('maintenance.staff_index', compact('items'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        return redirect()
            ->route('maintenance.index')
            ->with('error', 'Tambah maintenance manual dinonaktifkan. Jadwal dibuat otomatis dari data barang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        // Menampilkan detail maintenance dengan relasi
        return $maintenance->load(['barang', 'user']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $user = auth()->user();

        // Validasi khusus untuk Staff/PIC
        if (in_array($user->role, ['staff', 'pic'])) {
            // Pastikan maintenance ini milik user yang login
            if ($maintenance->id_user !== $user->id_user) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validate([
                'status' => 'required|in:proses,selesai',
                'catatan' => 'nullable|string',
                'tanggal_dikerjakan' => 'nullable|date',
            ]);

            // Jika status selesai tapi tanggal kosong, isi hari ini
            if ($validated['status'] === 'selesai' && empty($validated['tanggal_dikerjakan'])) {
                $validated['tanggal_dikerjakan'] = Carbon::today()->format('Y-m-d');
            }
            
            $maintenance->update($validated);
            
            return redirect()->route('maintenance.index')->with('success', 'Status maintenance berhasil diperbarui.');
        }

        // Validasi untuk Admin (bisa assign user)
        $validated = $request->validate([
            'id_user' => [
                'required',
                Rule::exists('users', 'id_user')->where(function ($query) {
                    $query->whereIn('role', ['staff', 'pic']);
                }),
            ],
            'tanggal_dikerjakan' => 'nullable|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:proses,selesai',
        ]);

        if ($validated['status'] === 'selesai' && empty($validated['tanggal_dikerjakan'])) {
            $validated['tanggal_dikerjakan'] = Carbon::today()->format('Y-m-d');
        }

        if ($validated['status'] === 'proses') {
            $validated['tanggal_dikerjakan'] = null;
        }

        $maintenance->update($validated);

        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        // Hapus data maintenance
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil dihapus.');
    }

    private function syncPreventiveMaintenanceSchedules(): void
    {
        $latestCompletedByAc = Maintenance::query()
            ->where('jenis', 'preventive')
            ->where('status', 'selesai')
            ->whereNotNull('tanggal_dikerjakan')
            ->orderByDesc('tanggal_dikerjakan')
            ->orderByDesc('id_maintenance')
            ->get()
            ->unique('id_ac')
            ->keyBy('id_ac');

        $barangs = Barang::query()->select('id_ac', 'tgl_instalasi')->get();
        foreach ($barangs as $barang) {
            $lastCompleted = $latestCompletedByAc->get($barang->id_ac);
            $baseDate = $lastCompleted?->tanggal_dikerjakan ?: $barang->tgl_instalasi;
            $nextSchedule = Carbon::parse($baseDate)->addMonthsNoOverflow(6)->format('Y-m-d');

            $exists = Maintenance::query()
                ->where('id_ac', $barang->id_ac)
                ->where('jenis', 'preventive')
                ->whereDate('tanggal_jadwal', $nextSchedule)
                ->exists();

            if (! $exists) {
                Maintenance::create([
                    'id_ac' => $barang->id_ac,
                    'id_user' => null,
                    'tanggal_jadwal' => $nextSchedule,
                    'tanggal_dikerjakan' => null,
                    'jenis' => 'preventive',
                    'catatan' => null,
                    'status' => 'pending',
                ]);
            }
        }
    }

    private function promoteDueMaintenanceToProses(): void
    {
        Maintenance::query()
            ->where('jenis', 'preventive')
            ->where('status', 'pending')
            ->whereDate('tanggal_jadwal', '<=', Carbon::today())
            ->whereNull('tanggal_dikerjakan')
            ->update(['status' => 'proses']);
    }
}
