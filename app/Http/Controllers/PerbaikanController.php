<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Perbaikan::with(['barang', 'user'])->latest('id_perbaikan')->get();
        $listBarang = Barang::select('id_ac', 'kode_bmn', 'merk', 'lokasi')->get();
        $listTeknisi = User::where('role', 'teknisi')->select('id_user', 'nama')->get();

        return view('perbaikan.index', compact('items', 'listBarang', 'listTeknisi'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'biaya' => 'nullable|numeric',
            'status' => ['nullable', Rule::in(['baru', 'proses', 'selesai'])],
        ]);

        // Menyimpan data perbaikan
        Perbaikan::create([
            'id_ac' => $validated['id_ac'],
            'tanggal_perbaikan' => $validated['tanggal_perbaikan'],
            'jenis_perbaikan' => $validated['jenis_perbaikan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_user' => $validated['id_user'],
            'biaya' => $validated['biaya'] ?? null,
            'status' => $validated['status'] ?? 'baru',
        ]);

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil ditambahkan.');
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
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'biaya' => 'nullable|numeric',
            'status' => ['nullable', Rule::in(['baru', 'proses', 'selesai'])],
        ]);

        // Update data perbaikan
        $perbaikan->update([
            'id_ac' => $validated['id_ac'],
            'tanggal_perbaikan' => $validated['tanggal_perbaikan'],
            'jenis_perbaikan' => $validated['jenis_perbaikan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_user' => $validated['id_user'],
            'biaya' => $validated['biaya'] ?? null,
            'status' => $validated['status'] ?? $perbaikan->status,
        ]);

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perbaikan $perbaikan)
    {
        // Hapus data perbaikan
        $perbaikan->delete();

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus.');
    }
}
