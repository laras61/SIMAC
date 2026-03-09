<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\Barang;
use App\Models\User;
use App\Models\Vendor;
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
        $user = auth()->user();

        // Jika staff/pic, arahkan ke view khusus staff
        if (in_array($user->role, ['staff', 'pic'])) {
            return $this->staffIndex();
        }

        $search = trim((string) request('q', ''));
        $status = trim((string) request('status', ''));

        $itemsQuery = Perbaikan::with(['barang', 'user', 'vendor'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('jenis_perbaikan', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%')
                        ->orWhereHas('barang', function ($barangQuery) use ($search) {
                            $barangQuery->where('kode_bmn', 'like', '%' . $search . '%')
                                ->orWhere('merk', 'like', '%' . $search . '%')
                                ->orWhere('lokasi', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('nama', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                            $vendorQuery->where('nama_vendor', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            });

        $items = $itemsQuery->latest('id_perbaikan')->get();
        $listVendors = Vendor::query()
            ->where('layanan', 'perbaikan')
            ->where('status', 'aktif')
            ->select('id_vendor', 'nama_vendor')
            ->orderBy('nama_vendor')
            ->get();
        $listBarang = Barang::select('id_ac', 'kode_bmn', 'merk', 'lokasi')->get();
        $listTeknisi = User::query()
            ->whereIn('role', ['teknisi', 'staff', 'admin'])
            ->select('id_user', 'nama')
            ->orderBy('nama')
            ->get();

        $editItem = null;
        if (request()->filled('edit')) {
            $editItem = Perbaikan::with(['barang', 'user', 'vendor'])->find(request('edit'));
        }

        return view('perbaikan.index', compact('items', 'listVendors', 'listBarang', 'listTeknisi', 'editItem', 'search', 'status'));
    }

    private function staffIndex()
    {
        $userId = auth()->id();
        $status = trim((string) request('status', ''));
        $items = Perbaikan::with(['barang', 'vendor'])
            ->where('id_user', $userId)
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('tanggal_perbaikan', 'desc')
            ->get();
        
        $listBarang = Barang::select('id_ac', 'kode_bmn', 'merk', 'lokasi')->get();
        $listVendors = Vendor::query()
            ->where('id_user', $userId)
            ->where('layanan', 'perbaikan')
            ->where('status', 'aktif')
            ->select('id_vendor', 'nama_vendor')
            ->orderBy('nama_vendor')
            ->get();
            
        return view('perbaikan.staff_index', compact('items', 'listBarang', 'listVendors', 'status'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        $user = auth()->user();
        if (in_array($user->role, ['staff', 'pic'])) {
            $request->merge(['id_user' => $user->id_user]);
        }
        
        // Validasi input
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'id_vendor' => [
                'nullable',
                Rule::exists('tbl_vendor', 'id_vendor')->where(function ($q) use ($user) {
                    if ($user && in_array($user->role, ['staff', 'pic'], true)) {
                        $q->where('id_user', $user->id_user);
                    }
                    $q->where('layanan', 'perbaikan')
                      ->where('status', 'aktif');
                }),
            ],
            'biaya' => 'nullable|numeric',
            'status' => ['nullable', Rule::in(['baru', 'proses', 'selesai'])],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menyimpan data perbaikan
        $perbaikan = Perbaikan::create([
            'id_ac' => $validated['id_ac'],
            'tanggal_perbaikan' => $validated['tanggal_perbaikan'],
            'jenis_perbaikan' => $validated['jenis_perbaikan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_user' => $validated['id_user'],
            'id_vendor' => $validated['id_vendor'] ?? null,
            'biaya' => $validated['biaya'] ?? null,
            'status' => $validated['status'] ?? 'baru',
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $perbaikan->uploadFoto($request->file('foto'));
        }

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
        $user = auth()->user();

        // Validasi khusus untuk Staff/PIC
        if (in_array($user->role, ['staff', 'pic'])) {
            // Pastikan perbaikan ini milik user yang login
            if ($perbaikan->id_user !== $user->id_user) {
                abort(403, 'Unauthorized');
            }

            $validated = $request->validate([
                'status' => ['required', Rule::in(['baru', 'proses', 'selesai'])],
                'tanggal_perbaikan' => 'required|date',
                'id_vendor' => [
                    'nullable',
                    Rule::exists('tbl_vendor', 'id_vendor')->where(function ($q) use ($user) {
                        $q->where('id_user', $user->id_user)
                          ->where('layanan', 'perbaikan')
                          ->where('status', 'aktif');
                    }),
                ],
                'biaya' => 'nullable|numeric',
                'deskripsi' => 'nullable|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handle upload foto
            if ($request->hasFile('foto')) {
                $perbaikan->uploadFoto($request->file('foto'));
            }

            $perbaikan->update($validated);
            
            return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil diperbarui.');
        }

        // Validasi untuk Admin (full update)
        $validated = $request->validate([
            'id_ac' => 'required|exists:tbl_barang,id_ac',
            'tanggal_perbaikan' => 'required|date',
            'jenis_perbaikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'id_vendor' => 'nullable|exists:tbl_vendor,id_vendor',
            'biaya' => 'nullable|numeric',
            'status' => ['nullable', Rule::in(['baru', 'proses', 'selesai'])],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update data perbaikan
        $perbaikan->update([
            'id_ac' => $validated['id_ac'],
            'tanggal_perbaikan' => $validated['tanggal_perbaikan'],
            'jenis_perbaikan' => $validated['jenis_perbaikan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'id_user' => $validated['id_user'],
            'id_vendor' => $validated['id_vendor'] ?? $perbaikan->id_vendor,
            'biaya' => $validated['biaya'] ?? null,
            'status' => $validated['status'] ?? $perbaikan->status,
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $perbaikan->uploadFoto($request->file('foto'));
        }

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perbaikan $perbaikan)
    {
        // Hapus foto jika ada
        if ($perbaikan->foto) {
            $perbaikan->deleteFoto();
        }
        
        // Hapus data perbaikan
        $perbaikan->delete();

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus.');
    }
}
