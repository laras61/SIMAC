<?php

namespace App\Http\Controllers;

use App\Models\Remainder;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemainderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = trim((string) request('q', ''));
        $status = trim((string) request('status', ''));

        $itemsQuery = Remainder::with('barang')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('jenis', 'like', '%' . $search . '%')
                        ->orWhere('email_tujuan', 'like', '%' . $search . '%')
                        ->orWhere('status_kirim', 'like', '%' . $search . '%')
                        ->orWhereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('kode_bmn', 'like', '%' . $search . '%')
                                ->orWhere('merk', 'like', '%' . $search . '%')
                                ->orWhere('lokasi', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status_kirim', $status);
            });

        $items = $itemsQuery->latest('id_remainder')->get();
        $listBarang = Barang::select('id_ac', 'kode_bmn', 'merk', 'lokasi')->orderBy('kode_bmn')->get();

        $editItem = null;
        if (request()->filled('edit')) {
            $editItem = Remainder::find(request('edit'));
        }

        return view('remainder.index', compact('items', 'listBarang', 'editItem', 'search', 'status'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_kirim' => 'required|date',
            'jenis' => 'required|in:maintenance,perbaikan',
            'email_tujuan' => 'required|email',
            'status_kirim' => 'required|string',
        ]);

        Remainder::create($validated);

        return redirect()->route('remainder.index')->with('success', 'Data reminder berhasil ditambahkan.');
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
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_kirim' => 'required|date',
            'jenis' => 'required|in:maintenance,perbaikan',
            'email_tujuan' => 'required|email',
            'status_kirim' => 'required|string',
        ]);

        $remainder->update($validated);

        return redirect()->route('remainder.index')->with('success', 'Data reminder berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Remainder $remainder)
    {
        $remainder->delete();

        return redirect()->route('remainder.index')->with('success', 'Data reminder berhasil dihapus.');
    }
}
