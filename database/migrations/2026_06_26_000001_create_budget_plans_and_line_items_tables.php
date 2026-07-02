<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // budget_plans
        if (! Schema::hasTable('budget_plans')) {
            Schema::create('budget_plans', function (Blueprint $table) {
                $table->id();
                $table->integer('fiscal_year')->index();
                $table->string('name')->nullable();
                $table->decimal('total_budget', 18, 2)->default(0);
            });
        }

        // budget_line_items
        if (! Schema::hasTable('budget_line_items')) {
            Schema::create('budget_line_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('budget_plan_id');
                $table->unsignedBigInteger('account_id');
                $table->decimal('allocated_amount', 18, 2)->default(0);
                $table->decimal('amount_academic', 18, 2)->default(0);
                $table->decimal('amount_regular', 18, 2)->default(0);
                $table->index('budget_plan_id');
                $table->index('account_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_line_items');
        Schema::dropIfExists('budget_plans');
    }
};
