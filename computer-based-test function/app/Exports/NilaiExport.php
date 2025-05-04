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
        $nilai = Nilai::where('id_kursus', $this->id_kursus)
                      ->with(['siswa', 'kursus', 'tipeNilai'])  // Pastikan relasi dengan tipeNilai
                      ->get();
    
        $data = [];
    
        foreach ($nilai as $n) {
            $data[] = [
                'Nomor' => $n->id_nilai,
                'Nama Siswa' => $n->siswa->nama_siswa,
                'Nilai Kuis' => implode(", ", $n->tipeNilai->pluck('nilai_kuis')->toArray()), // Gabungkan nilai kuis
                'Nilai UTS' => implode(", ", $n->tipeNilai->pluck('nilai_UTS')->toArray()),   // Gabungkan nilai UTS
                'Nilai UAS' => implode(", ", $n->tipeNilai->pluck('nilai_UAS')->toArray()),   // Gabungkan nilai UAS
                'Nilai Total' => $n->nilai_total, // Nilai total dihitung
            ];
        }
    
        return collect($data);
    }
    
    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Siswa',
            'Nilai Kuis',
            'Nilai UTS',
            'Nilai UAS',
            'Nilai Total',
        ];
    }
}
