<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropColumn(['student_code', 'full_name', 'name_prefix']);
        });
    }

    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            $table->string('student_code', 30)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('name_prefix', 20)->nullable();

            $table->index('student_code');
            $table->index('full_name');
        });
    }
};
