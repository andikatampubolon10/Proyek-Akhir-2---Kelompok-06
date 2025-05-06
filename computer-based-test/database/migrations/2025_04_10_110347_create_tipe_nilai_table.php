<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The table associated with the migration.
     *
     * @var string
     */
    protected $tableName = 'tipe_nilai';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipe_nilai', function (Blueprint $table) {
            $table->id('id_tipe_nilai');
            $table->decimal('nilai', 5, 0)->default(0);
            $table->unsignedBigInteger('id_tipe_ujian');
            $table->unsignedBigInteger('id_ujian');
            $table->unsignedBigInteger('id_siswa'); 
            $table->foreign('id_tipe_ujian')->references('id_tipe_ujian')->on('tipe_ujian')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_ujian')->references('id_ujian')->on('ujian')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
