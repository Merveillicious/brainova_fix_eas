<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        if (!empty($roles) && !in_array(session('user.role'), $roles)) {
            $role = session('user.role');
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
                'tutor' => redirect()->route('tutor.dashboard'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
