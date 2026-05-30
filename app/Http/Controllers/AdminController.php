<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'department')->paginate(20);
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        // ป้องกัน admin เปลี่ยน role ตัวเอง
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'ບໍ່ສາມາດປ່ຽນ Role ຂອງຕົນເອງໄດ້');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'ອັບເດດ Role ສຳເລັດ');
    }

    public function toggleActive(User $user, Request $request)
    {
        // ป้องกัน admin disable ตัวเอง
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'ບໍ່ສາມາດປ່ຽນສະຖານະຕົນເອງໄດ້');
        }

        $user->update(['is_active' => !$user->is_active]);

        $label = $user->is_active ? 'ເປີດໃຊ້ງານ' : 'ປິດໃຊ້ງານ';
        return back()->with('success', "ອັບເດດສະຖານະຜູ້ໃຊ້ເປັນ «{$label}» ສຳເລັດ");
    }
}