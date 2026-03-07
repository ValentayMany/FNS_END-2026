<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(
            ['username' => $request->username, 'password' => $request->password],
            $request->boolean('remember')
        )) {
            return back()->withErrors([
                'username' => 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect($this->redirectByRole(Auth::user()->role?->role_name));
    }

    private function redirectByRole(?string $role): string
    {
        return match($role) {
            'admin'                  => '/dashboard',
            'head_of_faculty'        => '/dashboard',
            'deputy_head_of_faculty' => '/dashboard',
            'head_of_finance'        => '/dashboard',
            'accountant'             => '/dashboard',
            'cashier'                => '/dashboard',
            'revenue_officer'        => '/dashboard',
            'requester'              => '/dashboard',
            default                  => '/dashboard',
        };
    }

public function destroy(Request $request)
{
    Auth::guard('web')->logout();
    $request->session()->flush();  // ← เปลี่ยนจาก invalidate() เป็น flush()
    $request->session()->regenerateToken();
    return redirect()->route('login');
}
}
