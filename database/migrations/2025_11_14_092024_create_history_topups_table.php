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
        Schema::create('history_topups', function (Blueprint $table) {
            $table->id();
            $table->decimal('jumlah_rupiah', 15, 2)->default(0);
            $table->decimal('jumlah_emas', 15, 2)->default(0);
            $table->decimal('jumlah_dcoin', 15, 2)->default(0);
            $table->string('riwayat_saldo', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_topups');
    }
};
