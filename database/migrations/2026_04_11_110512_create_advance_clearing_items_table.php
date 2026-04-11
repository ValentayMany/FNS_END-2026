<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advance_clearing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advance_request_id')->constrained('advance_requests')->cascadeOnDelete();
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('receipt_number')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advance_clearing_items');
    }
};
