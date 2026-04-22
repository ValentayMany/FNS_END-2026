<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Disconnect database after each response to prevent
 * exceeding max_user_connections on limited hosting.
 */
class DisconnectDatabase
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // ตัด connection ทันทีหลังส่ง response
        DB::disconnect();

        return $response;
    }
}
