<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $allowed = [
            'LAB A',
            'LAB B',
            'LAB C',
            'LAB D',
            'LAB E',
            'LAB F',
            'RUANG SEKRE',
            'RUANG DOSEN',
        ];

        DB::table('tbl_barang')
            ->where('lokasi', 'LAB')
            ->update(['lokasi' => 'LAB C']);

        Schema::table('tbl_barang', function (Blueprint $table) use ($allowed) {
            $table->enum('lokasi', $allowed)->default('LAB A')->change();
        });
    }

    public function down(): void
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
            ->where('lokasi', 'LAB C')
            ->update(['lokasi' => 'LAB']);

        Schema::table('tbl_barang', function (Blueprint $table) use ($allowed) {
            $table->enum('lokasi', $allowed)->default('LAB A')->change();
        });
    }
};

