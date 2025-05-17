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
        Schema::create('bisnis', function (Blueprint $table) {
            $table->id('id_bisnis');
            $table->string('nama_sekolah');
            $table->integer('jumlah_pendapatan')->default(500000);
            $table->string('perjanjian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bisnis');
    }
};
