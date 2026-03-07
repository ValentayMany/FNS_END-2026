<?php

namespace App\Http\Controllers;

use App\Models\AdvanceRequest;
use App\Models\Department;
use App\Services\WorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class RequestController extends Controller
{
    public function __construct(private WorkflowService $workflow) {}

    /** หน้าสร้างคำขอใหม่ */
    public function create()
    {
        $departments = Department::all();
        return view('requests.create', compact('departments'));
    }

    /** บันทึกคำขอ */
    public function store(Request $request)
    {
        $request->validate([
            'department_id'    => 'required|exists:departments,id',
            'requested_amount' => 'required|numeric|min:1',
            'description'      => 'required|string|max:500',
            'request_date'     => 'required|date',
        ]);

        AdvanceRequest::create([
            'requester_id'     => Auth::id(),
            'department_id'    => $request->department_id,
            'requested_amount' => $request->requested_amount,
            'description'      => $request->description,
            'request_date'     => $request->request_date,
            'status'           => 'draft',
        ]);

        return redirect()->route('requests.index')
            ->with('success', 'ສ້າງຄຳຂໍສຳເລັດແລ້ວ');
    }

    /** รายการคำขอของ Requester */
    public function index()
    {
        $requests = AdvanceRequest::where('requester_id', Auth::id())
            ->with('department')
           ->latest('request_date')  // ← เปลี่ยนตรงนี้
            ->paginate(10);

        $statusLabels = AdvanceRequest::statusLabels();

        return view('requests.index', compact('requests', 'statusLabels'));
    }

    /** รายละเอียดคำขอ */
    public function show(AdvanceRequest $advanceRequest)
    {
        // Requester เห็นแค่ของตัวเอง
        if ($advanceRequest->requester_id !== Auth::id()) {
            abort(403);
        }

        $advanceRequest->load('department', 'workflowLogs.actor.role');

        return view('requests.show', compact('advanceRequest'));
    }

    /** ส่งคำขอเข้า Workflow */
    public function submit(AdvanceRequest $advanceRequest)
    {
        if ($advanceRequest->requester_id !== Auth::id()) {
            abort(403);
        }

        try {
            $this->workflow->submit($advanceRequest, Auth::user());
            return back()->with('success', 'ສົ່ງຄຳຂໍສຳເລັດ ລໍຖ້າການກວດສອບ');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
