<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // เปลี่ยน type ให้ตรงกับ chart_of_accounts.id (int) แล้วเพิ่ม FK กลับ
        DB::statement('ALTER TABLE transactions
            MODIFY COLUMN account_id INT NULL,
            ADD CONSTRAINT transactions_account_id_foreign
            FOREIGN KEY (account_id) REFERENCES chart_of_accounts(id)
            ON DELETE SET NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE transactions
            DROP FOREIGN KEY transactions_account_id_foreign,
            MODIFY COLUMN account_id INT NOT NULL');
    }
};
