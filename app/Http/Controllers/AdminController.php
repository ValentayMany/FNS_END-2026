<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::with('role', 'department')->paginate(20);
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'ອັບເດດ Role ສຳເລັດ');
    }
}
