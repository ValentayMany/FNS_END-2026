<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop foreign key on transactions pointing to students
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        // 2. Rename students table to student
        Schema::rename('students', 'student');

        // 3. Re-add foreign key on transactions pointing to student
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('student')->nullOnDelete();
        });

        // 4. Create course table
        Schema::create('course', function (Blueprint $table) {
            $table->string('COURSEID', 10)->primary();
            $table->string('COURSENAME', 100);
            $table->string('LEVEL', 32);
            $table->tinyInteger('DEPTID');
        });

        // 5. Create creditrate table
        Schema::create('creditrate', function (Blueprint $table) {
            $table->tinyInteger('YEARLEVEL');
            $table->string('COURSEID', 10);
            $table->decimal('CREDITRATE', 10, 0);

            $table->primary(['YEARLEVEL', 'COURSEID']);
            $table->foreign('COURSEID')->references('COURSEID')->on('course')->onDelete('cascade');
        });

        // 6. Add columns to student table matching the professor's DDL
        Schema::table('student', function (Blueprint $table) {
            $table->string('STDID', 16)->nullable()->unique()->after('id');
            $table->string('TITLE', 10)->nullable()->after('STDID');
            $table->string('FRTNAME', 32)->nullable()->after('TITLE');
            $table->string('LSTNAME', 32)->nullable()->after('FRTNAME');
            $table->string('ETITLE', 10)->nullable()->after('LSTNAME');
            $table->string('EFNAME', 32)->nullable()->after('ETITLE');
            $table->string('ELNAME', 32)->nullable()->after('EFNAME');
            $table->date('BIRTHDATE')->nullable()->after('ELNAME');
            $table->string('BIRTHADDR', 100)->nullable()->after('BIRTHDATE');
            $table->string('CURRADDR', 100)->nullable()->after('BIRTHADDR');
            $table->string('PHONE', 40)->nullable()->after('CURRADDR');
            $table->string('EMAIL', 30)->nullable()->after('PHONE');
            $table->string('COURSEID', 10)->nullable()->after('EMAIL');
            $table->string('FUND', 24)->nullable()->after('COURSEID');
            $table->string('TALENT', 50)->nullable()->after('FUND');
            $table->string('BEFOREUNIV', 100)->nullable()->after('TALENT');
            $table->string('FUTUREWISH', 50)->nullable()->after('BEFOREUNIV');
            $table->string('CONTPERSON', 100)->nullable()->after('FUTUREWISH');
            $table->string('RELATION', 20)->nullable()->after('CONTPERSON');
            $table->string('CONTADDR', 100)->nullable()->after('RELATION');
            $table->string('CONTPHONE', 20)->nullable()->after('CONTADDR');
            $table->string('FATHERNAME', 40)->nullable()->after('CONTPHONE');
            $table->integer('FATHERAGE')->nullable()->after('FATHERNAME');
            $table->string('FATHEROCC', 30)->nullable()->after('FATHERAGE');
            $table->string('FATHERADDR', 100)->nullable()->after('FATHEROCC');
            $table->string('FATHERPHONE', 20)->nullable()->after('FATHERADDR');
            $table->string('MOTHERNAME', 40)->nullable()->after('FATHERPHONE');
            $table->integer('MOTHERAGE')->nullable()->after('MOTHERNAME');
            $table->string('MOTHEROCC', 30)->nullable()->after('MOTHERAGE');
            $table->string('MOTHERADDR', 100)->nullable()->after('MOTHEROCC');
            $table->string('MOTHERPHONE', 20)->nullable()->after('MOTHERADDR');
            $table->string('ORIGIN', 20)->nullable()->after('MOTHERPHONE');
            $table->string('NATION', 20)->nullable()->after('ORIGIN');
            $table->string('ETHNIC', 20)->nullable()->after('NATION');
            $table->string('RELIGION', 16)->nullable()->after('ETHNIC');
            $table->string('STYPE', 20)->nullable()->after('RELIGION');
            $table->string('CFROM', 50)->nullable()->after('STYPE');
            $table->date('YDATE')->nullable()->after('CFROM');
            $table->date('WDATE')->nullable()->after('YDATE');
            $table->date('KDATE')->nullable()->after('WDATE');
            $table->date('PSDATE')->nullable()->after('KDATE');
            $table->date('PCDATE')->nullable()->after('PSDATE');
            $table->string('SISTBROTH', 10)->nullable()->after('PCDATE');
            $table->string('SBPHONE', 40)->nullable()->after('SISTBROTH');

            // Add index and foreign key for COURSEID
            $table->index('COURSEID');
            $table->foreign('COURSEID')->references('COURSEID')->on('course')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Reverse changes
        Schema::table('student', function (Blueprint $table) {
            $table->dropForeign(['COURSEID']);
            $table->dropColumn([
                'STDID', 'TITLE', 'FRTNAME', 'LSTNAME', 'ETITLE', 'EFNAME', 'ELNAME',
                'BIRTHDATE', 'BIRTHADDR', 'CURRADDR', 'PHONE', 'EMAIL', 'COURSEID', 'FUND',
                'TALENT', 'BEFOREUNIV', 'FUTUREWISH', 'CONTPERSON', 'RELATION', 'CONTADDR',
                'CONTPHONE', 'FATHERNAME', 'FATHERAGE', 'FATHEROCC', 'FATHERADDR', 'FATHERPHONE',
                'MOTHERNAME', 'MOTHERAGE', 'MOTHEROCC', 'MOTHERADDR', 'MOTHERPHONE', 'ORIGIN',
                'NATION', 'ETHNIC', 'RELIGION', 'STYPE', 'CFROM', 'YDATE', 'WDATE', 'KDATE',
                'PSDATE', 'PCDATE', 'SISTBROTH', 'SBPHONE'
            ]);
        });

        Schema::dropIfExists('creditrate');
        Schema::dropIfExists('course');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::rename('student', 'students');

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();
        });
    }
};
