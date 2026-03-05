<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $hasPrimaryKey = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'tbl_maintenance')
            ->where('CONSTRAINT_TYPE', 'PRIMARY KEY')
            ->exists();

        if (! $hasPrimaryKey) {
            DB::statement('ALTER TABLE `tbl_maintenance` ADD PRIMARY KEY (`id_maintenance`)');
        }

        DB::statement(
            'ALTER TABLE `tbl_maintenance` MODIFY `id_maintenance` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT'
        );
    }

    public function down(): void
    {
        DB::statement(
            'ALTER TABLE `tbl_maintenance` MODIFY `id_maintenance` BIGINT UNSIGNED NOT NULL'
        );
    }
};
