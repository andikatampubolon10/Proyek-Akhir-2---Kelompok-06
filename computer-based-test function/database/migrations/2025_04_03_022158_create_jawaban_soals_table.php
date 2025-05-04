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
        Schema::create('jawaban_soal', function (Blueprint $table) {
            $table->id('id_jawaban_soal');
            $table->string('jawaban');
            $table->boolean('benar')->default(false);
            $table->unsignedBigInteger('id_soal');
            $table->unsignedBigInteger('id_tipe_soal');
            $table->foreign('id_soal')->references('id_soal')->on('soal')->onDelete('cascade');
            $table->foreign('id_tipe_soal')->references('id_tipe_soal')->on('tipe_soal')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_soals');
    }
};
