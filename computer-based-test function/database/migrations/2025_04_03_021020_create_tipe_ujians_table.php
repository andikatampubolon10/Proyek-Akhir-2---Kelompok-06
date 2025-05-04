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
        Schema::create('tipe_ujian', function (Blueprint $table) {
            $table->id('id_tipe_ujian');
            $table->enum('nama_tipe_ujian',['Kuis', 'Ujian Tengah Semester', 'Ujian Akhir Semester']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_ujians');
    }
};
