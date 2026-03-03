<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Barang::query()->latest('id_ac')->get();
        $editItem = null;

        if (request()->filled('edit')) {
            $editItem = Barang::find(request('edit'));
        }

        return view('barang.index', compact('items', 'editItem'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        $validated = $request->validate([
            'kode_bmn' => 'required|string|unique:tbl_barang,kode_bmn',
            'merk' => 'required|string',
            'serial_number' => 'required|string|unique:tbl_barang,serial_number',
            'tipe_ac' => 'required|string',
            'tgl_beli' => 'required|date',
            'tgl_instalasi' => 'required|date',
            'lokasi' => 'required|in:LAB A,LAB B,LAB,LAB D,LAB E,LAB F,RUANG SEKRE,RUANG DOSEN',
            'status' => 'required|in:aktif,rusak,nonaktif',
        ]);

        Barang::create($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return $barang;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_bmn' => 'required|string|unique:tbl_barang,kode_bmn,' . $barang->id_ac . ',id_ac',
            'merk' => 'required|string',
            'serial_number' => 'required|string|unique:tbl_barang,serial_number,' . $barang->id_ac . ',id_ac',
            'tipe_ac' => 'required|string',
            'tgl_beli' => 'required|date',
            'tgl_instalasi' => 'required|date',
            'lokasi' => 'required|in:LAB A,LAB B,LAB,LAB D,LAB E,LAB F,RUANG SEKRE,RUANG DOSEN',
            'status' => 'required|in:aktif,rusak,nonaktif',
        ]);

        $barang->update($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()
                ->route('barang.index')
                ->with('error', 'Data barang tidak bisa dihapus karena masih dipakai di data lain.');
        }
    }
}
