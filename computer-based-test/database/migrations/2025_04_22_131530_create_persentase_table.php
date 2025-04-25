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
        Schema::create('persentase', function (Blueprint $table) {
            $table->id('id_persentase');
            $table->decimal('persentase', 5, 0)->default(0); 
            $table->unsignedBigInteger('id_tipe_persentase'); 
            $table->unsignedBigInteger('id_kursus'); 
            $table->unsignedBigInteger('id_tipe_ujian'); 
            $table->foreign('id_tipe_persentase')->references('id_tipe_persentase')->on('tipe_persentase')->onDelete('cascade');
            $table->foreign('id_kursus')->references('id_kursus')->on('kursus')->onDelete('cascade');
            $table->foreign('id_tipe_ujian')->references('id_tipe_ujian')->on('tipe_ujian')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persentase');
    }
};
