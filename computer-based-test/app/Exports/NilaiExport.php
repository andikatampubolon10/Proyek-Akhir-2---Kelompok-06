<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    protected $id_kursus;

    public function __construct($id_kursus)
    {
        $this->id_kursus = $id_kursus;
    }

    public function collection()
    {
        return Nilai::with('siswa', 'kursus')
                    ->where('id_kursus', $this->id_kursus)
                    ->get(); 
    }

    public function headings(): array
    {
        return [
            'ID Siswa',
            'Nama Siswa',
            'Nama Kursus',
            'Nilai Kuis',
            'Nilai Ujian',
            'Nilai UAS',
            'Persentase Kuis',
            'Persentase UTS',
            'Persentase UAS',
            'Nilai Total',
        ];
    }
}
