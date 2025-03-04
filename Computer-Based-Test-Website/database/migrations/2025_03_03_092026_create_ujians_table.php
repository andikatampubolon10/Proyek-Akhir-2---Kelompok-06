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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->string('soal_ujian');
            $table->string('jawaban');
            $table->string('image');
            $table->string('password');
            $table->foreign('id_course')->constrained()->onDelete('cascade');
            $table->foreign('id_guru')->constrained()->onDelete('cascade');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->integer('total_nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
