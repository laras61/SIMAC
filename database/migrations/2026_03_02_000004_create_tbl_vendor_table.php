<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_vendor', function (Blueprint $table) {
            $table->id('id_vendor');
            $table->string('nama_vendor');
            $table->string('email')->nullable()->unique();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('pic_nama')->nullable();
            $table->string('pic_no_hp')->nullable();
            $table->string('layanan')->default('maintenance');
            $table->string('status')->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_vendor');
    }
};
