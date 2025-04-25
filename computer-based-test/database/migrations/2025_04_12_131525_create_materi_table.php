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
        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi');
            $table->string('judul_materi');
            $table->string('deskripsi')->nullable();
            $table->string('file');
            $table->string('file_url')->nullable();
            $table->timestamp('tanggal_materi');
            $table->unsignedBigInteger('id_kursus');
            $table->unsignedBigInteger('id_guru');
            $table->foreign('id_kursus')->references('id_kursus')->on('kursus')->onDelete('cascade');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
