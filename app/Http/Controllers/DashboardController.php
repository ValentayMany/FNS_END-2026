<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->role_name;

        return match($role) {
            'requester'                       => redirect()->route('requests.index'),
            'accountant',
            'head_of_finance',
            'deputy_head_of_faculty',
            'head_of_faculty'                 => redirect()->route('approval.index'),
            'cashier'                         => redirect()->route('cashier.index'),
            'revenue_officer'                 => redirect()->route('revenue.index'),
            'treasurer'                       => redirect()->route('treasurer.index'),
            'treasury_reconciliation_officer' => redirect()->route('treasury.index'),
            'admin'                           => redirect()->route('admin.users'),
            default                           => view('dashboard', [
                'user'         => $user,
                'actionList'   => null,
                'myRequests'   => null,
                'statusLabels' => [],
            ]),
        };
    }
}
