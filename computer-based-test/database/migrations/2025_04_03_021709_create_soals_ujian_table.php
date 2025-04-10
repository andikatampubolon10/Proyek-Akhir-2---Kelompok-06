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
        Schema::create('soal', function (Blueprint $table) {
            $table->id('id_soal');
            $table->string('soal');
            $table->unsignedBigInteger('id_ujian')->nullable();
            $table->unsignedBigInteger('id_latihan')->nullable();
            $table->foreign('id_ujian')->references('id_ujian')->on('ujian')->onDelete('cascade');
            $table->foreign('id_latihan')->references('id_latihan')->on('latihan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
