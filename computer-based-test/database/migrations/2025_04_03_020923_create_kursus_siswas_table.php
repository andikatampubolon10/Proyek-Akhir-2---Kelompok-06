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
        Schema::create('kursus_siswa', function (Blueprint $table) {
            $table->id('id_kursus_siswa');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_kursus');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_kursus')->references('id_kursus')->on('kursus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursus_siswas');
    }
};
