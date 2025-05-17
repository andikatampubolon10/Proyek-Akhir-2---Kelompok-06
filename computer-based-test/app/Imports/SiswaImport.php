<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Spatie\Permission\Models\Role;

class SiswaImport implements ToModel, WithStartRow, WithValidation
{
    protected $id_kelas;

    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        \Log::info('Processing row: ' . json_encode($row));

        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
            \Log::warning('Data tidak lengkap untuk baris: ' . json_encode($row));
            return null;
        }

        $SiswaRole = Role::where('name', 'siswa')->first();
        if (!$SiswaRole) {
            \Log::error('Role "siswa" tidak ditemukan.');
            throw new \Exception('Role "siswa" tidak ditemukan.');
        }

        $kelas = Kelas::where('nama_kelas', $row[4])->first();
        if (!$kelas) {
            \Log::warning('Kelas tidak ditemukan untuk nama: ' . $row[4]);
            return null;
        }

        \Log::info('Creating user for: ' . $row[0]);
        $user = User::create([
            'name' => $row[0],
            'email' => $row[2],
            'password' => Hash::make($row[3]),
        ]);

        $user->assignRole('Siswa');

        $operator = Operator::where('id_user', auth()->user()->id)->first();

        \Log::info('Creating siswa record for: ' . $row[0]);
        $siswa = Siswa::create([
            'nama_siswa' => $row[0],
            'nis' => $row[1],
            'id_user' => $user->id,
            'id_kelas' => $kelas->id_kelas,
            'id_operator' => $operator->id_operator,
            'status' => 'Aktif',
        ]);
        
        return $siswa;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|numeric|unique:siswa,nis',
            '2' => 'required|email|unique:users,email',
            '3' => 'required|string',
            '4' => 'required|string',
        ];
    }

    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            \Log::error('Import validation failed: ', $failure->errors());
        }
    }
}