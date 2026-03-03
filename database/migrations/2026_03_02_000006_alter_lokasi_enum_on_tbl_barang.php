<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $allowed = [
            'LAB A',
            'LAB B',
            'LAB',
            'LAB D',
            'LAB E',
            'LAB F',
            'RUANG SEKRE',
            'RUANG DOSEN',
        ];

        DB::table('tbl_barang')
            ->whereNotIn('lokasi', $allowed)
            ->update(['lokasi' => 'LAB A']);

        Schema::table('tbl_barang', function (Blueprint $table) use ($allowed) {
            $table->enum('lokasi', $allowed)->default('LAB A')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_barang', function (Blueprint $table) {
            $table->string('lokasi')->change();
        });
    }
};
