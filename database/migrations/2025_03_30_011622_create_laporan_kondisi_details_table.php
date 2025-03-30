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
        Schema::create('laporan_kondisi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_kondisi_id');
            $table->integer('luas_lahan');
            $table->date('estimasi_panen');
            $table->string('jenis_bibit');
            $table->string('foto_bibit');
            $table->string('lokasi_lahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kondisi_details');
    }
};
