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
            $table->id();
            $table->string('name', 20);
            $table->string('email', 40)->unique();
            $table->string('password', 50);
            $table->string('no_telpon', 20)->unique();
            $table->enum('role', ['admin', 'user', 'umkm', 'driver'])->default('user');
            $table->decimal('saldo_rupiah', 15, 2)->default(0);
            $table->decimal('saldo_emas', 15, 2)->default(0);
            $table->decimal('saldo_dcoin', 15, 2)->default(0);

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
