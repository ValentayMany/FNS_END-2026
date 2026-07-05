<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('dept_code', 20)->nullable()->after('id')->comment('ລະຫັດພາກ/ສ່ວນ ເຊັ່ນ 01, 02');
            $table->decimal('budget_amount', 18, 2)->default(0)->after('department_type')->comment('ງົບປະມານຂອງພາກ/ສ່ວນ');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['dept_code', 'budget_amount']);
        });
    }
};
