<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('tbl_maintenance', 'foto')) {
            Schema::table('tbl_maintenance', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tbl_maintenance', 'foto')) {
            Schema::table('tbl_maintenance', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
};