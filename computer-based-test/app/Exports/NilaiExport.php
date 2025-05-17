<?php

namespace App\Exports;

use App\Models\kursus_siswa;
use App\Models\Nilai;
use App\Models\TipeNilai;
use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $id_kursus;

    public function __construct($id_kursus)
    {
        $this->id_kursus = $id_kursus;
    }

    public function collection()
    {
        $kursusSiswa = kursus_siswa::where('id_kursus', $this->id_kursus)
            ->with('siswa') // Menyertakan relasi siswa
            ->get();

        $ujian = Ujian::where('id_kursus', $this->id_kursus)
            ->orderByRaw("FIELD(id_tipe_ujian, 1, 2, 3)") // Urutkan berdasarkan tipe ujian
            ->get();

        $data = $kursusSiswa->map(function ($kursusSiswa) use ($ujian) {
            $nilaiPerUjian = $ujian->map(function ($ujian) use ($kursusSiswa) {
                $nilai = TipeNilai::where('id_ujian', $ujian->id_ujian)
                    ->where('id_siswa', $kursusSiswa->siswa->id_siswa)
                    ->value('nilai');  

                return [
                    'nama_ujian' => $ujian->nama_ujian,
                    'nilai' => $nilai ? number_format($nilai, 2) : '-', 
                ];
            });

            $nilaiTotal = Nilai::where('id_siswa', $kursusSiswa->siswa->id_siswa)
                ->where('id_kursus', $this->id_kursus)
                ->value('nilai_total');

            $siswaData = [
                'nis' => $kursusSiswa->siswa->nis,
                'nama_siswa' => $kursusSiswa->siswa->nama_siswa,
            ];

            foreach ($nilaiPerUjian as $nilai) {
                $siswaData['nilai_' . strtolower(str_replace(' ', '_', $nilai['nama_ujian']))] = $nilai['nilai'];
            }

            $siswaData['nilai_total'] = $nilaiTotal ? number_format($nilaiTotal, 2) : '-';

            return $siswaData;
        });

        return $data->sortBy('nama_siswa');
    }

    public function headings(): array
    {
        $ujian = Ujian::where('id_kursus', $this->id_kursus)
            ->orderByRaw("FIELD(id_tipe_ujian, 1, 2, 3)") // Urutkan berdasarkan tipe ujian
            ->get();

        $heading = [
            'NIS',          
            'Nama Siswa',  
        ];

        foreach ($ujian as $ujianItem) {
            $heading[] = 'Nilai ' . $ujianItem->nama_ujian; // Kolom untuk nilai ujian
        }

        $heading[] = 'Nilai Total';

        return $heading;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . chr(65 + count($this->headings()) - 1) . '1')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . chr(65 + count($this->headings()) - 1) . '1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:' . chr(65 + count($this->headings()) - 1) . '1')->getFill()->getStartColor()->setRGB('D9EAD3');

        foreach (range('A', chr(65 + count($this->headings()) - 1)) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getStyle('A1:' . chr(65 + count($this->headings()) - 1) . '100')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
