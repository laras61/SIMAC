<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function hasPrimaryKey(string $table): bool
    {
        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_TYPE', 'PRIMARY KEY')
            ->exists();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('tbl_perbaikan') || ! Schema::hasColumn('tbl_perbaikan', 'id_perbaikan')) {
            return;
        }

        if (! $this->hasPrimaryKey('tbl_perbaikan')) {
            DB::statement('ALTER TABLE tbl_perbaikan ADD PRIMARY KEY (id_perbaikan)');
        }

        // Pastikan primary key perbaikan auto increment agar insert tidak gagal.
        DB::statement('ALTER TABLE tbl_perbaikan MODIFY id_perbaikan BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('tbl_perbaikan') || ! Schema::hasColumn('tbl_perbaikan', 'id_perbaikan')) {
            return;
        }

        DB::statement('ALTER TABLE tbl_perbaikan MODIFY id_perbaikan BIGINT UNSIGNED NOT NULL');
    }
};
