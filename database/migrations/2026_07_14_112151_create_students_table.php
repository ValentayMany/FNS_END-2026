<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code', 30)->unique()->comment('รหัสนักศึกษา เช่น 205N0004.25');
            $table->string('full_name', 255)->comment('ชื่อ-นามสกุล');
            $table->string('name_prefix', 20)->nullable()->comment('คำนำหน้า เช่น ທ້າວ, ນາງ, Mr.');
            $table->foreignId('degree_program_id')->nullable()->constrained('degree_programs')->nullOnDelete();
            $table->unsignedSmallInteger('study_year')->nullable()->comment('ปีที่เรียน เช่น 1, 2, 3');
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('faculty', 255)->nullable()->comment('คณะ/ภาควิชา');
            $table->unsignedSmallInteger('enrollment_year')->nullable()->comment('ปีที่เข้าศึกษา เช่น 2025');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('student_code');
            $table->index('full_name');
            $table->index(['enrollment_year', 'study_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
