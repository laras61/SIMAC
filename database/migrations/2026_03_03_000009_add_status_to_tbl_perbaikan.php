<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_perbaikan', function (Blueprint $table) {
            if (! Schema::hasColumn('tbl_perbaikan', 'status')) {
                $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru')->after('biaya');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_perbaikan', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_perbaikan', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
