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
        Schema::create('transportasis', function (Blueprint $table) {
    $table->id('id_transportasi');
    $table->string('informasi_transportasi', 100);
    $table->string('jenis_kendaraan', 50);
    $table->string('plat_nomor', 20);
    $table->decimal('harga', 10, 2);
    $table->decimal('diskon', 10, 2)->nullable();
    $table->text('informasi_online')->nullable();
    $table->text('deskripsi_transportasi')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportasis');
    }
};
