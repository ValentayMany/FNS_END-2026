<?php

namespace App\Http\Controllers;

use App\Models\AdvanceClearingAttachment;
use App\Models\AdvanceRequest;
use App\Services\WorkflowService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClearingController extends Controller
{
    public function __construct(private WorkflowService $workflow) {}

    /** Requester — รายการที่ต้องส่ง Clearing */
    public function index()
    {
        $requests = AdvanceRequest::where('requester_id', Auth::id())
            ->where('status', 'paid')
            ->with('department', 'clearingAttachments')
            ->latest('request_date')
            ->paginate(15);

        return view('clearing.clearing', compact('requests'));
    }

    /** Requester ส่ง Clearing พร้อมแนบไฟล์ */
    public function submit(Request $request, AdvanceRequest $advanceRequest)
    {
        if ($advanceRequest->requester_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'attachments'   => 'nullable|array|max:5',
            'attachments.*' => 'file|max:5120|mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx',
        ]);

        try {
            // อัปโหลดไฟล์ก่อน submit
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $stored = $file->store('clearing-attachments', 'local');
                    AdvanceClearingAttachment::create([
                        'advance_request_id' => $advanceRequest->id,
                        'original_name'      => $file->getClientOriginalName(),
                        'stored_name'        => $stored,
                        'mime_type'          => $file->getMimeType(),
                        'file_size'          => $file->getSize(),
                    ]);
                }
            }

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
            ->with('requester', 'department', 'clearingAttachments')
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

    /** Download ไฟล์แนบ */
    public function downloadAttachment(AdvanceClearingAttachment $attachment)
    {
        // ตรวจสอบสิทธิ์ — เป็นเจ้าของหรือ accountant เท่านั้น
        $user = Auth::user();
        $isOwner = $attachment->advanceRequest->requester_id === $user->id;
        if (!$isOwner && !$user->isAccountant()) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($attachment->stored_name)) {
            abort(404, 'ໄຟລ໌ບໍ່ພົບ');
        }

        return Storage::disk('local')->download(
            $attachment->stored_name,
            $attachment->original_name
        );
    }
}
