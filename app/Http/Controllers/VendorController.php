<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $items = Vendor::query()
            ->join('users', 'users.id_user', '=', 'tbl_vendor.id_user')
            ->select('tbl_vendor.*')
            ->with('user')
            ->latest('id_vendor')
            ->get();
        return response()->json($items);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:tbl_vendor,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'pic_nama' => 'nullable|string|max:255',
            'pic_no_hp' => 'nullable|string|max:20',
            'layanan' => 'nullable|in:perbaikan',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        $vendor = Vendor::create([
            ...$validated,
            'layanan' => 'perbaikan',
        ]);

        return response()->json($vendor, 201);
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
            'id_user' => 'required|exists:users,id_user',
            'pic_nama' => 'nullable|string|max:255',
            'pic_no_hp' => 'nullable|string|max:20',
            'layanan' => 'nullable|in:perbaikan',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        $vendor->update([
            ...$validated,
            'layanan' => 'perbaikan',
        ]);

        return $vendor;
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json(['message' => 'Vendor berhasil dihapus.']);
    }
}
