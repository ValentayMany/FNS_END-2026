<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = $user->role?->role_name;

        if (!in_array($userRole, $roles)) {
            abort(403, 'ທ່ານບໍ່ມີສິດເຂົ້າເຖິງໜ້ານີ້');
        }

        return $next($request);
    }
}
