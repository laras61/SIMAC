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
        Schema::create('tbl_maintenance', function (Blueprint $table) {
            $table->id('id_maintenance');
            $table->unsignedBigInteger('id_ac');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal_jadwal');
            $table->date('tanggal_dikerjakan')->nullable();
            $table->string('jenis'); // preventive / corrective
            $table->text('catatan')->nullable();
            $table->string('status'); // pending, selesai
            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_ac')->references('id_ac')->on('tbl_barang')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_maintenance');
    }
};
