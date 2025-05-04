<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeUjianSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipe_ujian')->insert([
            [
                'id_tipe_ujian' => 1,
                'nama_tipe_ujian' => 'Kuis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipe_ujian' => 2,
                'nama_tipe_ujian' => 'Ujian Tengah Semester',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipe_ujian' => 3,
                'nama_tipe_ujian' => 'Ujian Akhir Semester',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}