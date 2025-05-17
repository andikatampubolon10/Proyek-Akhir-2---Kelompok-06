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
        Schema::create('ujian', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->string('nama_ujian');
            $table->enum('acak', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('status_jawaban', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->float('grade');
            $table->string('password_masuk');   
            $table->string('password_keluar');
            $table->timestamp('waktu_mulai')->nullable(); 
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('durasi');
            $table->timestamp('tanggal_ujian')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('id_kursus');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_tipe_ujian');
            $table->foreign('id_kursus')->references('id_kursus')->on('kursus')->onDelete('cascade');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_tipe_ujian')->references('id_tipe_ujian')->on('tipe_ujian')->onDelete('cascade');
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
