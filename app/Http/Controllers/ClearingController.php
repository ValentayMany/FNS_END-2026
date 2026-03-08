<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Services\WorkflowService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ClearingController extends Controller
{
    public function __construct(private WorkflowService $workflow) {}

    /** Requester — รายการที่ต้องส่ง Clearing */
    public function index()
    {
        $requests = AdvanceRequest::where('requester_id', Auth::id())
            ->where('status', 'paid')
            ->with('department')
            ->latest('request_date')
            ->paginate(15);

        return view('clearing.clearing', compact('requests'));
    }

    /** Requester ส่ง Clearing */
    public function submit(AdvanceRequest $advanceRequest)
    {
        if ($advanceRequest->requester_id !== Auth::id()) {
            abort(403);
        }

        try {
            $this->workflow->submitClearing($advanceRequest, Auth::user());

            return back()->with('success', 'ສົ່ງໃບສະສາງສຳເລັດ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /** Accountant — รายการที่ต้องยืนยัน Clearing */
    public function pendingIndex()
    {
        $requests = AdvanceRequest::where('status', 'pending_clearing')
            ->with('requester', 'department')
            ->latest('request_date')
            ->paginate(15);

        return view('clearing.clearing', compact('requests'));
    }

    /** Accountant ยืนยัน Clearing */
    public function confirm(AdvanceRequest $advanceRequest)
    {
        try {
            $this->workflow->confirmClearing($advanceRequest, Auth::user());

            return back()->with('success', 'ຢືນຢັນການສະສາງສຳເລັດ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
