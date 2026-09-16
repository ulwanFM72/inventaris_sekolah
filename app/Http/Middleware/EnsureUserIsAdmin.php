<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Memastikan hanya user yang sudah login DAN berstatus admin
     * yang dapat melanjutkan request ke route admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            Auth::logout();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Anda harus login sebagai administrator.']);
        }

        return $next($request);
    }
}
