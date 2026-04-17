<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Some databases were created before `type` existed, or the original
     * migration was never applied. Revenue / expense screens require it.
     */
    public function up(): void
    {
        if (Schema::hasColumn('transactions', 'type')) {
            return;
        }

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type', ['income', 'expense'])->default('income');
        });

        if (! Schema::hasColumn('transactions', 'category')) {
            return;
        }

        $incomeCategories = [
            'ຄ່າບຳລຸງຫ້ອງທົດລອງ',
            'ຄ່າລົງທະບຽນປະລິນຍາຕີ',
            'ຄ່າຮັກສາສະຖານະພາບ',
            'ຄ່າໜ່ວຍກິດປະລິນຍາຕີ',
            'ຄ່າໜ່ວຍກິດປະລິນຍາໂທ',
            'ຄ່າລົງທະບຽນອັບເກຣດ',
            'ຄ່າບໍລິການວິຊາການ',
            'ແຫຼ່ງລາຍຮັບອື່ນໆ',
        ];

        $expenseCategories = [
            'ເງິນອຸດໜູນ ແລະ ນະໂຍບາຍ',
            'ການຊື້ ແລະ ການຊົມໃຊ້',
            'ການບໍລິການຈາກທາງນອກ',
            'ລາຍຈ່າຍກອງປະຊຸມ ສຳມະນາ ແລະ ຝຶກອົບຮົມ',
            'ດັດສົມ ແລະ ສົ່ງເສີມວັດທະນະທຳ - ສັງຄົມ',
            'ລາຍຈ່າຍບໍລິຫານປົກກະຕິອື່ນໆ',
            'ຊື້ຊັບສົມບັດຄົງທີ່',
        ];

        DB::table('transactions')
            ->whereIn('category', $incomeCategories)
            ->update(['type' => 'income']);

        DB::table('transactions')
            ->whereIn('category', $expenseCategories)
            ->update(['type' => 'expense']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('transactions', 'type')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};
