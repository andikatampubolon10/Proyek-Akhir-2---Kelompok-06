<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeSoalSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipe_soal')->insert([
            [
                'id_tipe_soal' => 1,
                'nama_tipe_soal' => 'Pilihan Berganda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipe_soal' => 2,
                'nama_tipe_soal' => 'Benar Salah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipe_soal' => 3,
                'nama_tipe_soal' => 'Isian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}