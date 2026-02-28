<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data perbaikan dengan relasi barang dan user
        return Perbaikan::with(['barang', 'user'])->get();
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'biaya' => 'nullable|numeric',
        ]);

        // Menyimpan data perbaikan
        return Perbaikan::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Perbaikan $perbaikan)
    {
        // Menampilkan detail perbaikan dengan relasi
        return $perbaikan->load(['barang', 'user']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perbaikan $perbaikan)
    {
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'biaya' => 'nullable|numeric',
        ]);

        // Update data perbaikan
        $perbaikan->update($request->all());

        return $perbaikan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perbaikan $perbaikan)
    {
        // Hapus data perbaikan
        $perbaikan->delete();

        return response()->json(['message' => 'Data perbaikan berhasil dihapus.']);
    }
}
