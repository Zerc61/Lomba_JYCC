<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('penginapans', function (Blueprint $table) {
            $table->id('id_penginapan');
            $table->string('nama_penginapan', 30);
            $table->string('alamat_penginapan', 30);
            $table->text('informasi_penginapan')->nullable();
            // $table->decimal('biaya_penginapan');
            $table->string('kategori', 30);
            $table->binary('foto_penginapan')->nullable();
            $table->string('lokasi', 30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penginapans');
    }
};
