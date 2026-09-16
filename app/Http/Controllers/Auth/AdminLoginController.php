<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Menampilkan form login admin.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Memproses percobaan login admin.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Hanya user dengan is_admin = true yang boleh masuk ke dashboard admin.
        if (
            !Auth::attempt($credentials, $request->boolean('remember')) ||
            !Auth::user()->is_admin
        ) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah, atau akun bukan administrator.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Logout admin.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
