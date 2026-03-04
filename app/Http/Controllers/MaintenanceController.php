<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        $items = $itemsQuery->latest('id_maintenance')->get();
        $listBarang = Barang::select('id_ac', 'kode_bmn', 'merk', 'lokasi')->get();
        $listTeknisi = User::query()
            ->whereIn('role', ['teknisi', 'staff', 'admin'])
            ->select('id_user', 'nama')
            ->orderBy('nama')
            ->get();

        $editItem = null;
        if (request()->filled('edit')) {
            $editItem = Maintenance::with(['barang', 'user'])->find(request('edit'));
        }

        return view('maintenance.index', compact('items', 'listBarang', 'listTeknisi', 'editItem', 'search', 'status'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_jadwal' => 'required|date',
            'tanggal_dikerjakan' => 'nullable|date',
            'jenis' => 'required|in:preventive,corrective',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
        ]);

        Maintenance::create($validated);

        return redirect()->route('maintenance.index')->with('success', 'Jadwal maintenance berhasil ditambahkan.');
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
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_jadwal' => 'required|date',
            'tanggal_dikerjakan' => 'nullable|date',
            'jenis' => 'required|in:preventive,corrective',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
        ]);

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
}
