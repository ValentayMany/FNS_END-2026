<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('departments')->where('department_name', 'ປະລິນຢາຕີ')->update(['department_name' => 'ປະລິນຍາຕີ']);
        DB::table('departments')->where('department_name', 'ປະລິນຢາໂທ')->update(['department_name' => 'ປະລິນຍາໂທ']);
        DB::table('departments')->where('department_name', 'ປະລິນຢາເອກ')->update(['department_name' => 'ປະລິນຍາເອກ']);
    }

    public function down(): void
    {
        DB::table('departments')->where('department_name', 'ປະລິນຍາຕີ')->update(['department_name' => 'ປະລິນຢາຕີ']);
        DB::table('departments')->where('department_name', 'ປະລິນຍາໂທ')->update(['department_name' => 'ປະລິນຢາໂທ']);
        DB::table('departments')->where('department_name', 'ປະລິນຍາເອກ')->update(['department_name' => 'ປະລິນຢາເອກ']);
    }
};
