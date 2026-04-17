<?php

namespace App\Services;

use App\Models\AdvanceRequest;
use App\Models\RequestWorkflowLog;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class WorkflowService
{
    /** Requester ส่งคำขอ */
    public function submit(AdvanceRequest $request, User $actor): void
    {
        if ($request->status !== 'draft') {
            throw new Exception('ສາມາດສົ່ງໄດ້ສະເພາະສະຖານະ draft ເທົ່ານັ້ນ');
        }

        DB::transaction(function () use ($request, $actor) {
            $this->log($request, $actor, 'submitted', 'ສົ່ງຄຳຂໍເຂົ້າລະບົບ');
            $request->update(['status' => 'pending_accountant_review']);
        });
    }

    /** Approver อนุมัติ */
    public function approve(AdvanceRequest $request, User $actor, ?string $comment = null): void
    {
        $this->ensureCanAct($request, $actor);

        $next = $this->nextStatus($request->status);
        if (! $next) {
            throw new Exception('ບໍ່ສາມາດອະນຸມັດໃນສະຖານະນີ້ໄດ້');
        }

        DB::transaction(function () use ($request, $actor, $comment, $next) {
            $this->log($request, $actor, 'approved', $comment ?? 'ອະນຸມັດ');
            $request->update(['status' => $next]);
        });
    }

    /** Approver ปฏิเสธ */
    public function reject(AdvanceRequest $request, User $actor, string $comment): void
    {
        $this->ensureCanAct($request, $actor);

        DB::transaction(function () use ($request, $actor, $comment) {
            $this->log($request, $actor, 'rejected', $comment);
            $request->update(['status' => 'rejected']);
        });
    }

    /** Cashier จ่ายเงิน */
    public function pay(AdvanceRequest $request, User $actor): void
    {
        if ($request->status !== 'approved') {
            throw new Exception('ສາມາດຈ່າຍໄດ້ສະເພາະສະຖານະ approved ເທົ່ານັ້ນ');
        }

        DB::transaction(function () use ($request, $actor) {
            $txn = Transaction::create([
                'transaction_date' => now()->toDateString(),
                'description' => 'ຈ່າຍເງິນສຳລັບ: '.$request->description,
                'amount' => $request->requested_amount,
                'account_id' => null,
                'department_id' => $request->department_id,
                'type' => 'expense',
            ]);

            $request->update([
                'status' => 'paid',
                'payment_transaction_id' => $txn->id,
            ]);

            $this->log($request, $actor, 'paid', 'ຈ່າຍເງິນແລ້ວ');
        });
    }

    /** Requester ส่งสะสาง */
    public function submitClearing(AdvanceRequest $request, User $actor): void
    {
        if ($request->status !== 'paid') {
            throw new Exception('ສາມາດສະສາງໄດ້ສະເພາະສະຖານະ paid ເທົ່ານັ້ນ');
        }

        DB::transaction(function () use ($request, $actor) {
            $this->log($request, $actor, 'clearing_submitted', 'ສົ່ງລາຍການສະສາງ');
            $request->update(['status' => 'pending_clearing']);
        });
    }

    /** Accountant ยืนยันสะสาง */
    public function confirmClearing(AdvanceRequest $request, User $actor): void
    {
        if ($request->status !== 'pending_clearing') {
            throw new Exception('ສະຖານະບໍ່ຖືກຕ້ອງ');
        }
        if (! $actor->isAccountant()) {
            throw new Exception('ສິດທິ Accountant ເທົ່ານັ້ນ');
        }

        DB::transaction(function () use ($request, $actor) {
            $this->log($request, $actor, 'clearing_confirmed', 'ຢືນຢັນການສະສາງ');
            $request->update(['status' => 'cleared']);
        });
    }

    // -------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------

    private function log(AdvanceRequest $request, User $actor, string $action, ?string $comments): void
    {
        RequestWorkflowLog::create([
            'request_id' => $request->id,
            'user_id' => $actor->id,
            'actor_role_name' => $actor->role?->role_name,
            'action' => $action,
            'timestamp' => now(),
            'comments' => $comments,
        ]);
    }

    private function nextStatus(string $current): ?string
    {
        return [
            'pending_accountant_review' => 'pending_finance_head_review',
            'pending_finance_head_review' => 'pending_deputy_head_approval',
            'pending_deputy_head_approval' => 'pending_faculty_head_approval',
            'pending_faculty_head_approval' => 'approved',
        ][$current] ?? null;
    }

    private function ensureCanAct(AdvanceRequest $request, User $actor): void
    {
        $map = [
            'pending_accountant_review' => 'accountant',
            'pending_finance_head_review' => 'head_of_finance',
            'pending_deputy_head_approval' => 'deputy_head_of_faculty',
            'pending_faculty_head_approval' => 'head_of_faculty',
        ];

        $required = $map[$request->status] ?? null;

        if (! $required || ! $actor->hasRole($required)) {
            throw new Exception('ທ່ານບໍ່ມີສິດດຳເນີນການໃນຂັ້ນຕອນນີ້');
        }
    }
}
