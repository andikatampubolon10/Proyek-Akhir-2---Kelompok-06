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
        Schema::create('kursus', function (Blueprint $table) {
            $table->id('id_kursus');
            $table->string('nama_kursus');
            $table->string('password');
            $table->string('image');
            $table->decimal('persentase_kuis', 5, 2)->default(0.00);
            $table->decimal('persentase_ujian', 5, 2)->default(0.00);
            $table->unsignedBigInteger('id_guru');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursuses');
    }
};
