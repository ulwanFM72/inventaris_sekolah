<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Batas maksimal percobaan login yang gagal sebelum dikunci sementara.
     */
    private const MAX_ATTEMPTS = 3;

    /**
     * Lama waktu kunci (detik) setelah percobaan gagal mencapai batas maksimal.
     */
    private const LOCKOUT_SECONDS = 60;

    /**
     * Menampilkan form login admin.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Memproses percobaan login admin.
     *
     * Dilindungi rate limiting: maksimal 3 kali percobaan gagal, setelah itu
     * dikunci selama 1 menit. Kunci dihitung per kombinasi email + alamat IP,
     * jadi tidak mengganggu percobaan login akun lain dari jaringan yang sama.
     */
    public function store(Request $request)
    {
        $key = $this->throttleKey($request);

        // Sudah mencapai batas maksimal & masih dalam periode kunci -> tolak
        // langsung tanpa memproses kredensial sama sekali.
        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return $this->lockoutResponse($request, $key);
        }

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

            RateLimiter::hit($key, self::LOCKOUT_SECONDS);

            // Baru saja mencapai batas maksimal pada percobaan ini -> kunci 1 menit.
            if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
                return $this->lockoutResponse($request, $key);
            }

            $sisaPercobaan = self::MAX_ATTEMPTS - RateLimiter::attempts($key);

            throw ValidationException::withMessages([
                'email' => "Email atau password salah, atau akun bukan administrator. Sisa percobaan: {$sisaPercobaan} kali sebelum dikunci sementara.",
            ]);
        }

        // Login berhasil -> hapus riwayat percobaan gagal untuk key ini.
        RateLimiter::clear($key);

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

    /**
     * Response saat sedang dalam periode kunci: kembali ke form login dengan
     * pesan error + sisa detik jeda, supaya view bisa menampilkan notifikasi
     * countdown dan menonaktifkan tombol login selama jeda berlangsung.
     */
    private function lockoutResponse(Request $request, string $key)
    {
        $detik = RateLimiter::availableIn($key);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => "Terlalu banyak percobaan login yang gagal. Silakan tunggu {$detik} detik sebelum mencoba lagi.",
            ])
            ->with('lockout_seconds', $detik);
    }

    /**
     * Key rate limiter dibuat dari email (case-insensitive) + IP address,
     * supaya percobaan brute force pada satu akun tidak ikut mengunci
     * pengguna lain, tapi tetap terikat ke sumber request yang sama.
     */
    private function throttleKey(Request $request): string
    {
        return Str::lower((string) $request->input('email')).'|'.$request->ip();
    }
}