<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login, biarkan request berlanjut
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Cek role dan redirect ke dashboard yang sesuai
        if ($user->hasRole('admin')) {
            // Jika user mencoba akses /login, redirect ke admin dashboard
            if ($request->is('login') || $request->is('register')) {
                return redirect()->route('admin.dashboard');
            }
        } elseif ($user->hasRole('owner')) {
            // Jika user mencoba akses /login, redirect ke owner dashboard
            if ($request->is('login') || $request->is('register')) {
                return redirect()->route('owner.dashboard');
            }
        } else {
            // User biasa
            if ($request->is('login') || $request->is('register')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
