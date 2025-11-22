<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id('id_wisata');
            $table->string('nama_user', 50);

            $table->string('nama', 100);

            // ENUM kategori
            $table->enum('kategori', [
                'Wisata Alam',
                'Wisata Budaya',
                'Wisata Sejarah',
                'Wisata Religi',
                'Wisata Kuliner',
                'Wisata Belanja',
                'Wisata Edukasi',
                'Wisata Petualangan',
                'Wisata Kesehatan',
            ]);

            $table->string('alamat_wisata', 255);
            $table->text('deskripsi');

            // FOTO BINARY - nullable
            $table->binary('foto_wisata')->nullable();

            $table->decimal('biaya_wisata', 15, 2)->default(0);
            $table->string('lokasi', 255);

            $table->timestamps();

        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
