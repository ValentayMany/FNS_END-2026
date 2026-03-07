<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->role_name;

        // Action List สำหรับ Approver
        $pendingMap = [
            'accountant'             => 'pending_accountant_review',
            'head_of_finance'        => 'pending_finance_head_review',
            'deputy_head_of_faculty' => 'pending_deputy_head_approval',
            'head_of_faculty'        => 'pending_faculty_head_approval',
        ];

        $actionList = null;
        if (isset($pendingMap[$role])) {
            $actionList = AdvanceRequest::where('status', $pendingMap[$role])
                ->with('requester', 'department')
                ->latest()
                ->paginate(10);
        }

        // คำขอของ Requester
        $myRequests = null;
        if ($role === 'requester') {
            $myRequests = AdvanceRequest::where('requester_id', $user->id)
                ->with('department')
                ->latest('request_date')  // ← เปลี่ยนตรงนี้
                ->limit(5)
                ->get();
        }

        $statusLabels = AdvanceRequest::statusLabels();

        return view('dashboard', compact('user', 'actionList', 'myRequests', 'statusLabels'));
    }
}
