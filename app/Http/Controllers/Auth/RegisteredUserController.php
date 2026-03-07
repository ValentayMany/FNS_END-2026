<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');  // ไม่ต้องส่ง roles/departments แล้ว
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users,username',
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'full_name'     => $request->full_name,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'role_id'       => 6,  // requester (default)
            'department_id' => 1,  // default department
            'is_active'     => 1,
        ]);

        // หลัง register เสร็จ → ไปหน้า login
        return redirect()->route('login')
            ->with('success', 'ລົງທະບຽນສຳເລັດ! ກະລຸນາເຂົ້າສູ່ລະບົບ');
    }
}
