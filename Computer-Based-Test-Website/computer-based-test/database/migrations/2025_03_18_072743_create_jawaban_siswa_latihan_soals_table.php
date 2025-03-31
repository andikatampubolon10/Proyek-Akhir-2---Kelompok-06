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
        Schema::create('jawaban_siswa_latihan_soals', function (Blueprint $table) {
            $table->id();
            $table->string('Jawaban_siswa');
            $table->boolean('Correct');
            $table->foreignId('latihan_soal_id')->constrained()->onDelete('cascade');
            $table->foreignId('latihan_soal_soal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswa_latihan_soals');
    }
};
