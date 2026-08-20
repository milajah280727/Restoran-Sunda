<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleDashboard
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Jika admin mencoba akses dashboard user, redirect ke admin dashboard
            if ($user->hasRole('admin') && $request->routeIs('dashboard')) {
                return redirect()->route('admin.dashboard');
            }

            // Jika owner mencoba akses dashboard user, redirect ke owner dashboard
            if ($user->hasRole('owner') && $request->routeIs('dashboard')) {
                return redirect()->route('owner.dashboard');
            }

            // Jika user biasa mencoba akses admin/owner dashboard, redirect ke user dashboard
            if (!$user->hasRole('admin') && !$user->hasRole('owner') &&
                ($request->routeIs('admin.dashboard') || $request->routeIs('owner.dashboard'))) {
                return redirect()->route('dashboard');
            }

            // Jika owner mencoba akses admin dashboard, redirect ke owner dashboard
            if ($user->hasRole('owner') && $request->routeIs('admin.dashboard')) {
                return redirect()->route('owner.dashboard');
            }

            // Jika admin mencoba akses owner dashboard, redirect ke admin dashboard
            if ($user->hasRole('admin') && $request->routeIs('owner.dashboard')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
