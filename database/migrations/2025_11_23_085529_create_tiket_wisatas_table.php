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
        Schema::create('tiket_wisatas', function (Blueprint $table) {
            $table->id('id_tiket');
            $table->unsignedBigInteger('id_wisata');
            $table->unsignedBigInteger('id_user');
            $table->integer('jumlah_tiket');
            $table->enum('metode_pembayaran', ['dcoin', 'rupiah']);
            $table->integer('total_harga_dcoin');
            $table->decimal('total_harga_rupiah', 15, 2);
            $table->enum('status_pembayaran', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->datetime('tanggal_pembelian');
            $table->datetime('tanggal_konfirmasi')->nullable();
            $table->timestamps();
            
            // PERBAIKAN: Tentukan kolom referensi untuk foreign key
            $table->foreign('id_wisata')->references('id_wisata')->on('wisatas')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade'); // Ubah baris ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_wisatas');
    }
};