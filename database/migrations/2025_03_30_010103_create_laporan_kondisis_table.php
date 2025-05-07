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
        Schema::create('laporan_kondisis', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('ditunda');
            $table->foreignId('kelompok_tani_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('komoditas_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('penyuluh_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kondisis');
    }
};
