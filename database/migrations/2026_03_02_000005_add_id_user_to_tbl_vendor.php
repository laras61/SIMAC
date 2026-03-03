<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_vendor', function (Blueprint $table) {
            if (! Schema::hasColumn('tbl_vendor', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('alamat');
                $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_vendor', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_vendor', 'id_user')) {
                $table->dropForeign(['id_user']);
                $table->dropColumn('id_user');
            }
        });
    }
};
