<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data maintenance dengan relasi barang dan user
        return Maintenance::with(['barang', 'user'])->get();
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_jadwal' => 'required|date',
            'tanggal_dikerjakan' => 'nullable|date',
            'jenis' => 'required|in:preventive,corrective',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
        ]);

        // Menyimpan data maintenance
        return Maintenance::create($request->all());
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
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'id_user' => 'required|exists:users,id_user',
            'tanggal_jadwal' => 'required|date',
            'tanggal_dikerjakan' => 'nullable|date',
            'jenis' => 'required|in:preventive,corrective',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai',
        ]);

        // Update data maintenance
        $maintenance->update($request->all());

        return $maintenance;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        // Hapus data maintenance
        $maintenance->delete();

        return response()->json(['message' => 'Data maintenance berhasil dihapus.']);
    }
}
