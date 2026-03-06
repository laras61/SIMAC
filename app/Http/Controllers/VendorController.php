<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $search = trim((string) request('q', ''));
        $status = trim((string) request('status', ''));

        $itemsQuery = Vendor::query()
            ->with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('nama_vendor', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%')
                        ->orWhere('layanan', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('nama', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            });

        $items = $itemsQuery
            ->latest('id_vendor')
            ->get();

        $listUsers = User::select('id_user', 'nama')->orderBy('nama')->get();

        $editItem = null;
        if (request()->filled('edit')) {
            $editItem = Vendor::find(request('edit'));
        }

        return view('vendor.index', compact('items', 'listUsers', 'editItem', 'search', 'status'));
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:tbl_vendor,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id_user',
            'layanan' => 'required|in:maintenance,perbaikan',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        Vendor::create($validated);

        return redirect()->route('vendor.index')->with('success', 'Data vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
        return $vendor;
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:tbl_vendor,email,' . $vendor->id_vendor . ',id_vendor',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id_user',
            'layanan' => 'required|in:maintenance,perbaikan',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendor.index')->with('success', 'Data vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendor.index')->with('success', 'Data vendor berhasil dihapus.');
    }
}
