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
        if (! Schema::hasTable('tbl_vendor')) {
            return;
        }

        Schema::table('tbl_vendor', function (Blueprint $table) {
            if (! Schema::hasColumn('tbl_vendor', 'pic_nama')) {
                $table->string('pic_nama')->nullable()->after('alamat');
            }

            if (! Schema::hasColumn('tbl_vendor', 'pic_no_hp')) {
                $table->string('pic_no_hp')->nullable()->after('pic_nama');
            }
        });

        Schema::table('tbl_vendor', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_vendor', 'id_user')) {
                $table->dropForeign(['id_user']);
                $table->dropColumn('id_user');
            }

            if (Schema::hasColumn('tbl_vendor', 'layanan')) {
                $table->dropColumn('layanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('tbl_vendor')) {
            return;
        }

        Schema::table('tbl_vendor', function (Blueprint $table) {
            if (! Schema::hasColumn('tbl_vendor', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('alamat');
                $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            }

            if (! Schema::hasColumn('tbl_vendor', 'layanan')) {
                $table->string('layanan')->default('maintenance')->after('id_user');
            }

            if (Schema::hasColumn('tbl_vendor', 'pic_nama')) {
                $table->dropColumn('pic_nama');
            }

            if (Schema::hasColumn('tbl_vendor', 'pic_no_hp')) {
                $table->dropColumn('pic_no_hp');
            }
        });
    }
};

