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
        Schema::create('topups', function (Blueprint $table) {
            $table->id('id_topup');
            $table->unsignedBigInteger('id_user');
            $table->string('name', 20);
            $table->string('email', 40);
            $table->string('no_telpon', 20);
            $table->string('role');
            $table->decimal('saldo_rupiah', 15, 2)->default(0);
            $table->decimal('saldo_emas', 15, 2)->default(0);
            $table->integer('saldo_dcoin')->default(0);
            $table->string('pajak');
            $table->string('admin');
            $table->text('metode_pembayaran');
            $table->enum('status_bayar', ['belum', 'sudah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
