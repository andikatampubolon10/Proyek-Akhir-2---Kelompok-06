<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class persentaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipe_persentase')->insert([
            ['nama_persentase' => 'persentase_kuis'],
            ['nama_persentase' => 'persentase_UTS'],
            ['nama_persentase' => 'persentase_UAS'],
        ]);
    }
}
