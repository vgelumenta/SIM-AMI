<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Contact
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // dd($user->contact);

            // Cek apakah pengguna memiliki kontak
            if (empty($user->contact) && !$request->routeIs('contacts.edit') && !$request->routeIs('contacts.update')) {
                return redirect('/contacts/' . $user->id . '/edit');
            }
        }

        return $next($request);
    }
}
