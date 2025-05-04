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
        Schema::create('nilai_kursus', function (Blueprint $table) {
            $table->id('id_nilai_kursus');
            $table->decimal('nilai_tipe_ujian', 5, 0)->default(0);
            $table->unsignedBigInteger('id_kursus');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_tipe_ujian');
            $table->foreign('id_kursus')->references('id_kursus')->on('kursus')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_tipe_ujian')->references('id_tipe_ujian')->on('tipe_ujian')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_kursus');
    }
};
