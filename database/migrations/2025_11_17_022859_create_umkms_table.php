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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id('id_umkm');
            $table->string('nama_umkm', 30);
            $table->string('pemilik', 30);
            $table->text('informasi_umkm');
            $table->integer('pasokan_umkm');
            $table->decimal('harga', 13,2);
            $table->string('kategori', 30);
            $table->binary('foto_umkm')->nullable();
            $table->dateTime('jam_buka')->nullable();
            $table->dateTime('jam_tutup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
