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
        Schema::create('penyuluh_kelompok_tanis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyuluh_terdaftar_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kelompok_tani_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyuluh_kelompok_tanis');
    }
};
