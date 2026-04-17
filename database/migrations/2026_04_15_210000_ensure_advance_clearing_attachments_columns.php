<?php

use App\Database\MigrationAdvanceRequestForeignKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Older create_advance_clearing_attachments migration only had id (+ timestamps).
     * Eloquent expects advance_request_id, file metadata, etc.
     */
    public function up(): void
    {
        if (! Schema::hasTable('advance_clearing_attachments')) {
            Schema::create('advance_clearing_attachments', function (Blueprint $table) {
                $table->id();
                MigrationAdvanceRequestForeignKey::addColumnAndForeignKey($table, 'id');
                $table->string('original_name');
                $table->string('stored_name');
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->timestamp('uploaded_at')->nullable();
            });

            return;
        }

        Schema::table('advance_clearing_attachments', function (Blueprint $table) {
            if (! Schema::hasColumn('advance_clearing_attachments', 'advance_request_id')) {
                MigrationAdvanceRequestForeignKey::addColumnAndForeignKey($table, 'id');
            }
            if (! Schema::hasColumn('advance_clearing_attachments', 'original_name')) {
                $table->string('original_name')->after('advance_request_id');
            }
            if (! Schema::hasColumn('advance_clearing_attachments', 'stored_name')) {
                $table->string('stored_name')->after('original_name');
            }
            if (! Schema::hasColumn('advance_clearing_attachments', 'mime_type')) {
                $table->string('mime_type')->nullable()->after('stored_name');
            }
            if (! Schema::hasColumn('advance_clearing_attachments', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable()->after('mime_type');
            }
            if (! Schema::hasColumn('advance_clearing_attachments', 'uploaded_at')) {
                $table->timestamp('uploaded_at')->nullable()->after('file_size');
            }
        });
    }

    public function down(): void
    {
        //
    }
};
