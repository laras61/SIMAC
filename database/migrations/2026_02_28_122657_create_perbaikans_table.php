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
        Schema::create('tbl_perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->unsignedBigInteger('id_ac');
            $table->date('tanggal_perbaikan');
            $table->string('jenis_perbaikan');
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->decimal('biaya', 15, 2)->nullable();
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
        Schema::dropIfExists('tbl_perbaikan');
    }
};
