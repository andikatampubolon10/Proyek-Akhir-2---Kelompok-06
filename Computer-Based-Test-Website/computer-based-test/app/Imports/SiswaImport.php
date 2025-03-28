<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithStartRow, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $siswaRole = Role::where('name', 'siswa')->first();
    
        if (!$siswaRole) {
            throw new \Exception('Role "siswa" tidak ditemukan.');
        }

        $user = User::create([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
        ]);

        $user->assignRole($siswaRole);
        $siswa = Siswa::create([
            'name' => $row[0], 
            'nis' => $row[1],
            'password' => Hash::make($row[2]), 
            'user_id' => $user->id,
        ]);
    
        return $siswa;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|numeric',
            '2' => 'required|string',
        ];
    }
}