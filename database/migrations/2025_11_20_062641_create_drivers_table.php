<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id_driver');
            $table->string('nama', 30);
            $table->integer('umur')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('email', 50)->nullable()->unique();
            $table->decimal('rating', 3, 2)->nullable();
            $table->text('alamat')->nullable();
            $table->binary('foto_driver')->nullable(); // binary data
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
