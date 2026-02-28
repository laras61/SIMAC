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
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->id('id_ac');
            $table->string('kode_bmn');
            $table->string('merk');
            $table->string('serial_number');
            $table->string('tipe_ac');
            $table->date('tgl_beli');
            $table->date('tgl_instalasi');
            $table->string('lokasi');
            $table->enum('status', ['aktif', 'rusak', 'nonaktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_barang');
    }
};
