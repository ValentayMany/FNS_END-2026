<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // เลขที่ใบเสร็จ - หลายรายการของนักศึกษาคนเดียวจะใช้เลขเดียวกัน
            $table->string('receipt_no', 20)->nullable()->after('id')->comment('เลขที่ใบเสร็จ เช่น 16864');
            // รหัสนักศึกษา
            $table->unsignedBigInteger('student_id')->nullable()->after('receipt_no');
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();

            $table->index('receipt_no');
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropIndex(['receipt_no']);
            $table->dropIndex(['student_id']);
            $table->dropColumn(['receipt_no', 'student_id']);
        });
    }
};
