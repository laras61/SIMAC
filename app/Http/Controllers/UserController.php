<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (in_array($user->role, ['staff', 'pic'])) {
            return view('user.staff_profile', compact('user'));
        }

        $search = trim((string) request('q', ''));
        $role = trim((string) request('role', ''));

        $items = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%');
                });
            })
            ->when($role !== '', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest('id_user')
            ->get();
        $editItem = null;

        if (request()->filled('edit')) {
            $editItem = User::find(request('edit'));
        }

        return view('user.index', compact('items', 'editItem', 'search', 'role'));
    }

    /**
     * Insert a newly created resource in storage.
     */
    public function insert(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'nullable|string|max:15',
            'role' => ['nullable', Rule::in(['admin', 'staff', 'pic'])],
            'foto_profi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'staff',
        ]);

        if ($request->hasFile('foto_profi')) {
            $user->uploadFotoProfi($request->file('foto_profi'));
        }

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Pastikan user hanya bisa mengupdate dirinya sendiri jika bukan admin
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id_user) {
            abort(403, 'Unauthorized');
        }

        // Validasi input update
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
            'no_hp' => 'nullable|string|max:15',
            'role' => ['nullable', Rule::in(['admin', 'staff', 'pic'])],
            'foto_profi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
        ];

        // Role hanya bisa diupdate oleh admin
        if (auth()->user()->role === 'admin' && ! empty($validated['role'])) {
            $data['role'] = $validated['role'];
        }

        // Jika password diisi, enkripsi dan tambahkan ke data yang diupdate
        if (! empty($validated['password'])) {
            // Verifikasi password saat ini
            if (! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
            }
            $data['password'] = Hash::make($validated['password']);
        }
        
        $user->update($data);

        if ($request->hasFile('foto_profi')) {
            $user->uploadFotoProfi($request->file('foto_profi'));
        }

        // Jika staff/pic, redirect kembali ke halaman dashboard
        if (in_array(auth()->user()->role, ['staff', 'pic'])) {
            return redirect()->route('staff.dashboard')->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->foto_profi) {
                $user->deleteFotoProfi();
            }
            $user->delete();
            return redirect()
                ->route('user.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'User tidak bisa dihapus karena masih dipakai di data lain.');
        }
    }
}
