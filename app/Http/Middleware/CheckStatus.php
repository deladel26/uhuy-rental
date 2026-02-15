<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            abort(401, 'Belum login');
        }

        if (Auth::user()->status !== 'aktif') {
            abort(403, 'Akun tidak aktif');
        }

        return $next($request);
    }
}
