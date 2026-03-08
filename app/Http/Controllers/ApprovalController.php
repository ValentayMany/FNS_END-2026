<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Services\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ApprovalController extends Controller
{
    public function __construct(private WorkflowService $workflow) {}

    /** Action List — รายการที่ต้องอนุมัติ */
   public function index()
{
    $user = Auth::user();
    $role = $user->role?->role_name;

    $statusMap = [
        'accountant'             => 'pending_accountant_review',
        'head_of_finance'        => 'pending_finance_head_review',
        'deputy_head_of_faculty' => 'pending_deputy_head_approval',
        'head_of_faculty'        => 'pending_faculty_head_approval',
    ];

    $pendingStatus = $statusMap[$role] ?? null;

    $requests = $pendingStatus
        ? AdvanceRequest::where('status', $pendingStatus)
            ->with('requester', 'department')
            ->latest('request_date')
            ->paginate(15)
        : collect();

    return view('approvals.index', compact('requests', 'user'));
}

    /** อนุมัติ */
    public function approve(Request $request, AdvanceRequest $advanceRequest)
    {
        try {
            $this->workflow->approve($advanceRequest, Auth::user(), $request->comment);
            return back()->with('success', 'ອະນຸມັດສຳເລັດ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** ปฏิเสธ */
    public function reject(Request $request, AdvanceRequest $advanceRequest)
    {
        $request->validate(['comment' => 'required|string|max:500']);

        try {
            $this->workflow->reject($advanceRequest, Auth::user(), $request->comment);
            return back()->with('success', 'ປະຕິເສດຄຳຂໍແລ້ວ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** รายละเอียดคำขอ */
    public function show(AdvanceRequest $advanceRequest)
    {
        $advanceRequest->load('requester.role', 'department', 'workflowLogs.actor.role');
        return view('approvals.show', compact('advanceRequest'));
    }

}
