<?php

namespace App\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Aligns FK column type with advance_requests.id (MySQL 3780 if BIGINT vs INT mismatch).
 */
final class MigrationAdvanceRequestForeignKey
{
    public static function addColumnAndForeignKey(Blueprint $table, ?string $after = 'id'): void
    {
        $connection = Schema::getConnection();
        if ($connection->getDriverName() !== 'mysql') {
            $col = $table->foreignId('advance_request_id');
            if ($after !== null) {
                $col->after($after);
            }
            $col->constrained('advance_requests')->cascadeOnDelete();

            return;
        }

        if (! Schema::hasTable('advance_requests')) {
            $col = $table->unsignedBigInteger('advance_request_id');
            if ($after !== null) {
                $col->after($after);
            }

            return;
        }

        $meta = DB::selectOne(
            'SELECT DATA_TYPE, COLUMN_TYPE FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?',
            ['advance_requests', 'id']
        );

        if ($meta === null) {
            $col = $table->foreignId('advance_request_id');
            if ($after !== null) {
                $col->after($after);
            }
            $col->constrained('advance_requests')->cascadeOnDelete();

            return;
        }

        $dataType = strtolower((string) $meta->DATA_TYPE);
        $columnType = strtolower((string) ($meta->COLUMN_TYPE ?? ''));
        $unsigned = str_contains($columnType, 'unsigned');

        $column = match ($dataType) {
            'bigint' => $unsigned
                ? $table->unsignedBigInteger('advance_request_id')
                : $table->bigInteger('advance_request_id'),
            'int', 'integer' => $unsigned
                ? $table->unsignedInteger('advance_request_id')
                : $table->integer('advance_request_id'),
            'mediumint' => $unsigned
                ? $table->unsignedMediumInteger('advance_request_id')
                : $table->mediumInteger('advance_request_id'),
            'smallint' => $unsigned
                ? $table->unsignedSmallInteger('advance_request_id')
                : $table->smallInteger('advance_request_id'),
            default => $table->unsignedBigInteger('advance_request_id'),
        };

        if ($after !== null) {
            $column->after($after);
        }

        $table->foreign('advance_request_id')
            ->references('id')
            ->on('advance_requests')
            ->cascadeOnDelete();
    }
}
