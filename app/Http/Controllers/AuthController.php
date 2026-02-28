<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => 'required|string', // Bisa berupa email atau nama
            'password' => 'required|string',
        ]);

        // Cek apakah input adalah email atau nama
        $loginType = filter_var($credentials['login_id'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nama';

        // Persiapkan kredensial untuk Auth::attempt
        $authCredentials = [
            $loginType => $credentials['login_id'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'message' => 'Login gagal. Periksa kembali email/nama dan password Anda.',
        ], 401);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}
