<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // ງົບປະມານຕັ້ງຕົ້ນ (ບໍ່ປ່ຽນແປງ — ໃຊ້ສຳລັບ Dashboard)
            $table->decimal('initial_budget', 15, 2)->default(0)->after('budget_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('initial_budget');
        });
    }
};
