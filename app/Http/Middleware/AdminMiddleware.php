<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Jika user sudah login dan memiliki role "admin", lanjut ke halaman yang diminta
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // ❌ Jika bukan admin, kembalikan ke halaman utama dengan pesan error
        return redirect('/')
            ->with('error', '❌ Akses ditolak. Halaman ini hanya untuk Admin.');
    }
}
