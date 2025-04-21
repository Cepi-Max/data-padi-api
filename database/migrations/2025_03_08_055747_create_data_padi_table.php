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
        Schema::create('data_padi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('jumlah_padi');
            $table->decimal('jenis_padi');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('foto_padi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_padi');
    }
};
