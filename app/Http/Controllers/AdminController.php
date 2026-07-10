<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('role', 'department')->paginate(20);
        $roles = Role::all();
        $departments = Department::orderBy('department_name')->get();

        return view('admin.users', compact('users', 'roles', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'password' => bcrypt($request->password),
            'is_active' => true,
        ]);

        return back()->with('success', 'ເພີ່ມຜູ້ໃຊ້ໃໝ່ສຳເລັດ');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'full_name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'username' => $request->username,
            'full_name' => $request->full_name,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
        ];

        // ป้องกัน admin เปลี่ยน role ตัวเอง
        if ($user->id === $request->user()->id && (int)$request->role_id !== (int)$user->role_id) {
            return back()->with('error', 'ບໍ່ສາມາດປ່ຽນ Role ຂອງຕົນເອງໄດ້');
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return back()->with('success', 'ອັບເດດຂໍ້ມູນຜູ້ໃຊ້ສຳເລັດ');
    }

    public function updateRole(Request $request, User $user)
    {
        // ป้องกัน admin เปลี่ยน role ตัวเอง
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'ບໍ່ສາມາດປ່ຽນ Role ຂອງຕົນເองໄດ້');
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