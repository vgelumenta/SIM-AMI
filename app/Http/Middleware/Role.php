<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika permintaan menuju halaman '/roles' atau 'password.reset'
        if ($request->is('roles') || $request->routeIs('password.reset') || $request->is('contacts/*/edit') || $request->is('contacts/*')) {
            return $next($request);
        }

        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Key cache berdasarkan user ID
            $cacheKey = 'user_role_' . Auth::id();

            // Cek apakah cache ada atau kadaluarsa
            if (!Cache::has($cacheKey)) {
                // Jika pengguna hanya memiliki satu role, simpan ke cache
                if (Auth::user()->roles->count() === 1) {
                    Cache::put($cacheKey, Auth::user()->getRoleNames()->first(), 60 * 720); // cache untuk 12 jam
                } else {
                    return redirect('/roles');
                }
            } else {
                // Jika cache masih ada, ambil role yang sebelumnya dari cache
                $cachedRole = Cache::get($cacheKey);

                // Perbarui cache dengan role yang sama (sebelumnya)
                Cache::put($cacheKey, $cachedRole, 60 * 720); // perpanjang masa cache dengan value yang sama
            }
        }

        return $next($request);
    }
}
