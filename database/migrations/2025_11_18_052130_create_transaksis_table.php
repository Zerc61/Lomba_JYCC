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
        Schema::create('transaksis', function (Blueprint $table) {
                $table->id('id_transaksi');
                $table->integer('id_transportasi');
                $table->integer('id_user');
                $table->integer('id_paket');
                $table->string('harga', 30);
                $table->time('jam_berangkat');
                $table->time('jam_tiba');
                $table->date('tanggal_berangkat');
                $table->date('tanggal_tiba');
                $table->string('tujuan', 100);
                $table->string('status', 20);
                $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
