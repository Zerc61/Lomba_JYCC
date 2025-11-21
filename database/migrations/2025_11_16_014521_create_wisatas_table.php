<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id('id_wisata'); // primary key jadi id_wisata
            $table->string('nama', 100);
            $table->enum('kategori', [
                'Wisata Alam',
                'Wisata Budaya',
                'Wisata Sejarah',
                'Wisata Religi',
                'Wisata Kuliner',
                'Wisata Belanja',
                'Wisata Edukasi',
                'Wisata Petualangan',
                'Wisata Kesehatan'
            ]);
            $table->string('alamat_wisata');
            $table->text('deskripsi');
            $table->binary('foto_wisata')->nullable();
            $table->decimal('biaya_wisata', 15, 2);
            $table->string('lokasi', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
