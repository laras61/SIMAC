<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tbl_maintenance', 'id_vendor')) {
            Schema::table('tbl_maintenance', function (Blueprint $table) {
                $table->unsignedBigInteger('id_vendor')->nullable()->after('id_user');
                $table->foreign('id_vendor')->references('id_vendor')->on('tbl_vendor')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_maintenance', 'id_vendor')) {
            Schema::table('tbl_maintenance', function (Blueprint $table) {
                $table->dropForeign(['id_vendor']);
                $table->dropColumn('id_vendor');
            });
        }
    }
};
