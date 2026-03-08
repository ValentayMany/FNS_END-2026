<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Services\WorkflowService;
use Illuminate\Support\Facades\Auth;
use Exception;

class CashierController extends Controller
{
    public function __construct(private WorkflowService $workflow) {}

    public function index()
    {
        $requests = AdvanceRequest::where('status', 'approved')
            ->with('requester', 'department')
            ->latest('request_date')
            ->paginate(15);

        return view('cashier.cashier', compact('requests'));
    }

    public function pay(AdvanceRequest $advanceRequest)
    {
        try {
            $this->workflow->pay($advanceRequest, Auth::user());
            return back()->with('success', 'ຈ່າຍເງິນສຳເລັດ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
