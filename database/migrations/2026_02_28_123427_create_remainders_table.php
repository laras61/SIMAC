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
        Schema::create('tbl_remainder', function (Blueprint $table) {
            $table->id('id_remainder');
            $table->unsignedBigInteger('id_ac');
            $table->date('tanggal_kirim');
            $table->string('jenis'); // maintenance/perbaikan
            $table->string('email_tujuan');
            $table->string('status_kirim'); // pending, sent, failed
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_ac')->references('id_ac')->on('tbl_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_remainder');
    }
};
