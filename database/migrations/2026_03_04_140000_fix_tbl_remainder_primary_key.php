<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $hasPrimary = DB::selectOne("SELECT COUNT(*) AS cnt FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_remainder' AND CONSTRAINT_TYPE = 'PRIMARY KEY'");

        if ((int) ($hasPrimary->cnt ?? 0) === 0) {
            DB::statement('ALTER TABLE `tbl_remainder` ADD PRIMARY KEY (`id_remainder`)');
        }

        DB::statement('ALTER TABLE `tbl_remainder` MODIFY `id_remainder` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `tbl_remainder` MODIFY `id_remainder` BIGINT UNSIGNED NOT NULL');

        $hasPrimary = DB::selectOne("SELECT COUNT(*) AS cnt FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_remainder' AND CONSTRAINT_TYPE = 'PRIMARY KEY'");

        if ((int) ($hasPrimary->cnt ?? 0) > 0) {
            DB::statement('ALTER TABLE `tbl_remainder` DROP PRIMARY KEY');
        }
    }
};
