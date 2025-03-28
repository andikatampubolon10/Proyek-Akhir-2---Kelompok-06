<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToModel, WithStartRow, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cek apakah NIS sudah ada di tabel siswa
        if (Siswa::where('nis', $row[1])->exists()) {
            throw new \Exception("NIS {$row[1]} sudah ada di tabel siswa.");
        }
    
        // Cek apakah NIS sudah ada di tabel guru
        if (Guru::where('nip', $row[1])->exists()) {
            throw new \Exception("NIP {$row[1]} sudah ada di tabel guru.");
        }
    
        // Cari atau buat role "guru"
        $guruRole = Role::where('name', 'guru')->first();
    
        if (!$guruRole) {
            throw new \Exception('Role "guru" tidak ditemukan.');
        }
    
        // Buat pengguna (User )
        $user = User::create([
            'name' => $row[0], // Nama guru
            'email' => $row[1], // NIP sebagai email
            'password' => Hash::make($row[2]), // Password
        ]);
    
        // Assign role "guru" ke pengguna
        $user->assignRole($guruRole);
    
        // Buat guru (Guru) dan hubungkan dengan pengguna
        $guru = Guru::create([
            'name' => $row[0], // Nama guru
            'nip' => $row[1], // NIP
            'password' => Hash::make($row[2]), // Password
            'user_id' => $user->id, 
        ]);
    
        return $guru;
    }
    public function rules(): array
    {
        return [
            '0' => 'required|string', // Nama guru
            '1' => 'required|numeric|unique:gurus,nip', // NIP (harus unik)
            '2' => 'required|string', // Password
        ];
    }
}