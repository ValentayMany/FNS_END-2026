<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Older rows missed actor_role_name or stored "requester" while action was
     * "approved". Infer the approver role from order of approval (matches WorkflowService).
     */
    public function up(): void
    {
        if (! Schema::hasTable('request_workflow_logs') || ! Schema::hasColumn('request_workflow_logs', 'actor_role_name')) {
            return;
        }

        $approverRoles = [
            0 => 'accountant',
            1 => 'head_of_finance',
            2 => 'deputy_head_of_faculty',
            3 => 'head_of_faculty',
        ];

        $requestIds = DB::table('request_workflow_logs')
            ->where('action', 'approved')
            ->where(function ($q) {
                $q->whereNull('actor_role_name')
                    ->orWhere('actor_role_name', '')
                    ->orWhere('actor_role_name', 'requester');
            })
            ->distinct()
            ->pluck('request_id');

        foreach ($requestIds as $requestId) {
            $logs = DB::table('request_workflow_logs')
                ->where('request_id', $requestId)
                ->where('action', 'approved')
                ->orderBy('timestamp')
                ->orderBy('id')
                ->get();

            foreach ($logs as $idx => $log) {
                $expected = $approverRoles[$idx] ?? null;
                if ($expected === null) {
                    break;
                }

                $bad = $log->actor_role_name === null
                    || $log->actor_role_name === ''
                    || $log->actor_role_name === 'requester';

                if ($bad) {
                    DB::table('request_workflow_logs')
                        ->where('id', $log->id)
                        ->update(['actor_role_name' => $expected]);
                }
            }
        }

        // Submitted step: snapshot should be requester when missing
        DB::table('request_workflow_logs')
            ->where('action', 'submitted')
            ->where(function ($q) {
                $q->whereNull('actor_role_name')->orWhere('actor_role_name', '');
            })
            ->update(['actor_role_name' => 'requester']);
    }

    /**
     * Cannot safely reverse inferred values.
     */
    public function down(): void
    {
        //
    }
};
