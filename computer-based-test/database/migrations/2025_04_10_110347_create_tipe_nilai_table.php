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
            $table->decimal('nilai_kuis', 5, 0)->default(0);
            $table->decimal('nilai_UTS', 5, 0)->default(0);
            $table->decimal('nilai_UAS', 5, 0)->default(0);
            $table->integer('tipe_ujian');
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
