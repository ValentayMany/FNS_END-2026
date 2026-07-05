<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Department;

return new class extends Migration
{
    public function up(): void
    {
        $depts = Department::all();
        foreach ($depts as $index => $dept) {
            if (empty($dept->dept_code)) {
                $dept->dept_code = sprintf('%02d', $index + 1);
                $dept->save();
            }
        }
    }

    public function down(): void
    {
    }
};
