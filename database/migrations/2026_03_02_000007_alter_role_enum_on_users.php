<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $allowed = ['admin', 'teknisi'];

        DB::table('users')
            ->whereNotIn('role', $allowed)
            ->update(['role' => 'teknisi']);

        Schema::table('users', function (Blueprint $table) use ($allowed) {
            $table->enum('role', $allowed)->default('teknisi')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->change();
        });
    }
};
