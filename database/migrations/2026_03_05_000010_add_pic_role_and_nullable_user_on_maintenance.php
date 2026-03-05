<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff', 'pic'])->default('staff')->change();
        });

        DB::table('users')
            ->whereNotIn('role', ['admin', 'staff', 'pic'])
            ->update(['role' => 'staff']);

        Schema::table('tbl_maintenance', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'pic')
            ->update(['role' => 'staff']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->default('staff')->change();
        });

        $fallbackUserId = DB::table('users')->orderBy('id_user')->value('id_user');
        if ($fallbackUserId !== null) {
            DB::table('tbl_maintenance')
                ->whereNull('id_user')
                ->update(['id_user' => $fallbackUserId]);
        }

        Schema::table('tbl_maintenance', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable(false)->change();
        });
    }
};
