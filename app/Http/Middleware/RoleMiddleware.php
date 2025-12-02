<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Penting: Impor Facade Auth

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  Daftar role yang diizinkan (misal: 'admin', 'calon_siswa')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Jika belum, arahkan ke halaman login
        }

        $user = Auth::user(); // Ambil data user yang sedang login

        // Periksa apakah role user ada dalam daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika tidak, tampilkan error 403 (Unauthorized)
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request); // Lanjutkan request jika role user diizinkan
    }
}