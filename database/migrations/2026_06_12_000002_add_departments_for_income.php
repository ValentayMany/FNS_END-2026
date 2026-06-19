<?php

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Department::firstOrCreate(
            ['department_name' => 'ປທ'],
            ['department_type' => 'income']
        );

        Department::firstOrCreate(
            ['department_name' => 'ປຕ'],
            ['department_type' => 'income']
        );

        Department::firstOrCreate(
            ['department_name' => 'ປອ'],
            ['department_type' => 'income']
        );
    }

    public function down(): void
    {
        Department::whereIn('department_name', ['ປທ', 'ປຕ', 'ປອ'])->delete();
    }
};
