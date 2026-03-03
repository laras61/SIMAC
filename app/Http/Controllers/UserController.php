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
        $items = User::query()->latest('id_user')->get();
        $editItem = null;

        if (request()->filled('edit')) {
            $editItem = User::find(request('edit'));
        }

        return view('user.index', compact('items', 'editItem'));
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
            'role' => ['nullable', Rule::in(['admin', 'teknisi'])],
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'teknisi',
        ]);

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
        // Validasi input update
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8', // Password opsional saat update
            'no_hp' => 'nullable|string|max:15',
            'role' => ['nullable', Rule::in(['admin', 'teknisi'])],
        ]);

        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
        ];

        // Jika password diisi, enkripsi dan tambahkan ke data yang diupdate
        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if (! empty($validated['role'])) {
            $data['role'] = $validated['role'];
        }

        $user->update($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
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
