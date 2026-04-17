<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('request_workflow_logs')) {
            return;
        }

        if (Schema::hasColumn('request_workflow_logs', 'actor_role_name')) {
            return;
        }

        Schema::table('request_workflow_logs', function (Blueprint $table) {
            $table->string('actor_role_name', 64)->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('request_workflow_logs')) {
            return;
        }

        if (Schema::hasColumn('request_workflow_logs', 'actor_role_name')) {
            Schema::table('request_workflow_logs', function (Blueprint $table) {
                $table->dropColumn('actor_role_name');
            });
        }
    }
};
