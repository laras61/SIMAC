<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $allowedTemp = ['admin', 'teknisi', 'staff'];
        $allowedFinal = ['admin', 'staff'];

        Schema::table('users', function (Blueprint $table) use ($allowedTemp) {
            $table->enum('role', $allowedTemp)->default('staff')->change();
        });

        DB::table('users')
            ->where('role', 'teknisi')
            ->update(['role' => 'staff']);

        DB::table('users')
            ->whereNotIn('role', $allowedFinal)
            ->update(['role' => 'staff']);

        Schema::table('users', function (Blueprint $table) use ($allowedFinal) {
            $table->enum('role', $allowedFinal)->default('staff')->change();
        });
    }

    public function down(): void
    {
        $allowed = ['admin', 'teknisi'];

        DB::table('users')
            ->where('role', 'staff')
            ->update(['role' => 'teknisi']);

        Schema::table('users', function (Blueprint $table) use ($allowed) {
            $table->enum('role', $allowed)->default('teknisi')->change();
        });
    }
};
