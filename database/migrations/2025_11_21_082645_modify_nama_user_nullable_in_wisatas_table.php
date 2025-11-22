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
    Schema::table('wisatas', function (Blueprint $table) {
        $table->string('nama_user', 50)->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('wisatas', function (Blueprint $table) {
        $table->string('nama_user', 50)->nullable(false)->change();
    });
}

};
