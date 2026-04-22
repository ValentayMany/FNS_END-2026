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

        if (! Auth::attempt(
            ['username' => $request->username, 'password' => $request->password],
            $request->boolean('remember')
        )) {
            return back()->withErrors([
                'username' => 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ',
            ])->onlyInput('username');
        }

        // ตรวจสอบว่า account ถูก disable หรือไม่
        if (!Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'username' => 'ບັນຊີຂອງທ່ານຖືກລະງັບການໃຊ້ງານ ກະລຸນາຕິດຕໍ່ผູ້ดູแລລະບົບ',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect($this->redirectByRole(Auth::user()->role?->role_name));
    }

   private function redirectByRole(?string $role): string
{
    return match ($role) {
        'requester'                       => route('requests.index'),
        'accountant'                      => route('approvals.index'),
        'head_of_finance'                 => route('approvals.index'),
        'deputy_head_of_faculty'          => route('approvals.index'),
        'head_of_faculty'                 => route('approvals.index'),
        'cashier'                         => route('cashier.index'),
        'revenue_officer'                 => route('revenue.index'),
        'treasurer'                       => route('treasurer.index'),  // ← เอาแค่อันนี้
        'treasury_reconciliation_officer' => route('treasury.index'),
        'admin'                           => route('admin.users'),
        default                           => route('dashboard'),
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
