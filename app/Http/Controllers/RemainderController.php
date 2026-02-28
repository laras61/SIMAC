<?php

namespace App\Http\Controllers;

use App\Models\Remainder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemainderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data remainder dengan relasi barang
        return Remainder::with('barang')->get();
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_kirim' => 'required|date',
            'jenis' => 'required|in:maintenance,perbaikan',
            'email_tujuan' => 'required|email',
            'status_kirim' => 'required|string',
        ]);

        // Menyimpan data remainder
        return Remainder::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Remainder $remainder)
    {
        // Menampilkan detail remainder dengan relasi
        return $remainder->load('barang');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Remainder $remainder)
    {
        // Validasi input
        $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_kirim' => 'required|date',
            'jenis' => 'required|in:maintenance,perbaikan',
            'email_tujuan' => 'required|email',
            'status_kirim' => 'required|string',
        ]);

        // Update data remainder
        $remainder->update($request->all());

        return $remainder;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Remainder $remainder)
    {
        // Hapus data remainder
        $remainder->delete();

        return response()->json(['message' => 'Data remainder berhasil dihapus.']);
    }
}
