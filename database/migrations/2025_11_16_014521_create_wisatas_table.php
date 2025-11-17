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
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id('id_wisata');
            $table->string('nama_wisata', 30); // FIX
            $table->string('alamat_wisata', 30);
            $table->text('informasi_wisata'); // FIX typo
            $table->decimal('biaya_wisata', 10, 2);
            $table->string('kategori', 30);
            $table->binary('foto_wisata')->nullable();
            $table->string('lokasi', 30);
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
