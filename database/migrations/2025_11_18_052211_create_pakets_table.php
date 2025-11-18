<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
<<<<<<< HEAD
           $table->id('id_paket');
           $table->integer('id_umkm');
           $table->string('jenis_paket', 50);
           $table->text('deskripsi_paket')->nullable();
           $table->timestamps();
});

=======
            $table->id('id_paket');
            $table->string('jenis_paket', 100);
            $table->text('deskripsi_paket');
            $table->string('total_paket');
            $table->timestamps();

        });
>>>>>>> d1e06a44df17ad962ac9ea6d530ff1855bcbdafe
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
