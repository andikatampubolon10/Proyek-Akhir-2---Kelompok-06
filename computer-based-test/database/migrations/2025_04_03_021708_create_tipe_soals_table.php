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
            Schema::create('tipe_soal', function (Blueprint $table) {
                $table->id('id_tipe_soal');
                $table->enum('nama_tipe_soal', ['Pilihan Berganda', 'Benar Salah', 'Isian']);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_soals');
    }
};
