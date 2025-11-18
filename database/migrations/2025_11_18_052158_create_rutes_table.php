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
        Schema::create('rutes', function (Blueprint $table) {
              $table->id('id_lokasi');
      
              $table->integer('id_online');
              $table->integer('id_umkm');
      
              $table->decimal('latitude', 10, 6);
              $table->decimal('longitude', 10, 6);
      
              $table->string('alamat', 100);
      
              $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
