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
        Schema::create('latihan', function (Blueprint $table) {
            $table->id('id_latihan');
            $table->String('Topik');
            $table->enum('acak', ['Aktif', 'Tidak Aktif']);
            $table->enum('status_jawaban', ['Aktif', 'Tidak Aktif']);
            $table->integer('grade');
            $table->unsignedBigInteger('id_guru'); 
            $table->unsignedBigInteger('id_kurikulum');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_kelas');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_kurikulum')->references('id_kurikulum')->on('kurikulum')->onDelete('cascade');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latihan');
    }
};
