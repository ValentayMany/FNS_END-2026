<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ตรวจสอบว่า user ถูก disable หรือไม่
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'ບັນຊີຂອງທ່ານຖືກລະງັບການໃຊ້ງານ');
        }

        $userRole = $user->role?->role_name;

        if (!in_array($userRole, $roles)) {
            abort(403, 'ທ່ານບໍ່ມີສິດເຂົ້າເຖິງໜ້ານີ້');
        }

        return $next($request);
    }
}
