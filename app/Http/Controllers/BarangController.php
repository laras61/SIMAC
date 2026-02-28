<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Memastikan Controller di-import
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data barang dari database
        return Barang::all();
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'kode_bmn' => 'required|string|unique:tbl_barang,kode_bmn',
            'merk' => 'required|string',
            'serial_number' => 'required|string|unique:tbl_barang,serial_number',
            'tipe_ac' => 'required|string',
            'tgl_beli' => 'required|date',
            'tgl_instalasi' => 'required|date',
            'lokasi' => 'required|string',
            'status' => 'required|in:aktif,rusak,nonaktif',
        ]);

        // Menyimpan data baru ke database menggunakan Model
        return Barang::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        // Mengembalikan data detail barang
        return $barang;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        // Validasi input update (perhatikan unique rule untuk kode_bmn dan serial_number agar mengecualikan data saat ini)
        $request->validate([
            'kode_bmn' => 'required|string|unique:tbl_barang,kode_bmn,' . $barang->id_ac . ',id_ac',
            'merk' => 'required|string',
            'serial_number' => 'required|string|unique:tbl_barang,serial_number,' . $barang->id_ac . ',id_ac',
            'tipe_ac' => 'required|string',
            'tgl_beli' => 'required|date',
            'tgl_instalasi' => 'required|date',
            'lokasi' => 'required|string',
            'status' => 'required|in:aktif,rusak,nonaktif',
        ]);

        // Update data di database
        $barang->update($request->all());

        // Mengembalikan data barang yang sudah diupdate
        return $barang;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        // Menghapus data dari database
        $barang->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Barang berhasil dihapus.']);
    }
}
