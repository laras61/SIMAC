<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tbl_vendor', 'pic_nama')) {
            Schema::table('tbl_vendor', function (Blueprint $table) {
                $table->dropColumn('pic_nama');
            });
        }

        if (Schema::hasColumn('tbl_vendor', 'pic_no_hp')) {
            Schema::table('tbl_vendor', function (Blueprint $table) {
                $table->dropColumn('pic_no_hp');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('tbl_vendor', 'pic_nama')) {
            Schema::table('tbl_vendor', function (Blueprint $table) {
                $table->string('pic_nama')->nullable();
            });
        }

        if (! Schema::hasColumn('tbl_vendor', 'pic_no_hp')) {
            Schema::table('tbl_vendor', function (Blueprint $table) {
                $table->string('pic_no_hp')->nullable();
            });
        }
    }
};
