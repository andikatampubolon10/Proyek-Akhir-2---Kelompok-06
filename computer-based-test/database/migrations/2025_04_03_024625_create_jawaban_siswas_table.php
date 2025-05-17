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
        Schema::create('jawaban_siswa', function (Blueprint $table) {
            $table->id('id_jawaban_siswa');
            $table->string('jawaban_siswa');
            $table->unsignedBigInteger('id_soal');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_jawaban_soal');
            $table->foreign('id_soal')->references('id_soal')->on('soal')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_jawaban_soal')->references('id_jawaban_soal')->on('jawaban_soal')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
