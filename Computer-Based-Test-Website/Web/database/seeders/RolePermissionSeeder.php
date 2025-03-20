<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission; 
use App\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

                // Hapus semua data dari tabel model_has_permissions dan model_has_roles terlebih dahulu
                \DB::table('model_has_permissions')->delete();
                \DB::table('model_has_roles')->delete();
        
                // Hapus semua data dari tabel permissions dan roles
                Permission::query()->delete();
                Role::query()->delete();

                $permissions = [
                    // Admin
                    'create Operator',
                    'view Operator',
                    'edit Operator',
                    'delete Operator',
                    'create Bisnis',
                    'view Bisnis',
                    'delete Bisnis',
                
                    // Operator
                    'create Siswa',
                    'view Siswa',
                    'edit Siswa',
                    'delete Siswa',
                    'create Guru',
                    'view Guru',
                    'edit Guru',
                    'delete Guru',
                    'create Kelas',
                    'view Kelas',
                    'edit Kelas',
                    'create Kurikulum',
                    'view Kurikulum',
                    'edit Kurikulum',
                    'create Mapel',
                    'view Mapel',
                    'edit Mapel',
                    'delete Mapel',
                
                    // Guru
                    'view Course',
                    'create Course',
                    'edit Course',
                    'delete Course',
                    'create latihanSoal',
                    'view latihanSoal',
                    'edit latihanSoal',
                    'delete latihanSoal',
                    'create Nilai',
                    'view Nilai',
                    'edit Nilai',
                ];

        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $adminRole = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web', 
        ]);

        $adminRole->givePermissionTo([
            'create Operator',
            'view Operator',
            'edit Operator',
            'delete Operator',
            'create Bisnis',
            'view Bisnis',
            'delete Bisnis',
        ]);

        $operatorRole = Role::create([
            'name' => 'Operator',
            'guard_name' => 'web', 
        ]);

        $operatorRole->givePermissionTo([
            'create Siswa',
            'view Siswa',
            'edit Siswa',
            'delete Siswa',
            'create Guru',
            'view Guru',
            'edit Guru',
            'delete Guru',
            'create Kelas',
            'view Kelas',
            'edit Kelas',
            'create Kurikulum',
            'view Kurikulum',
            'edit Kurikulum',
            'create Mapel',
            'view Mapel',
            'edit Mapel',
            'delete Mapel',
        ]);

        $guruRole = Role::create([
            'name' => 'Guru',
            'guard_name' => 'web', 
        ]);   
        
        $guruRole->givePermissionTo([
            'view Siswa',
            'view Guru',
            'view Kelas',
            'view Kurikulum',
            'view Mapel',
            'view Course',
            'create Course',
            'edit Course',
            'delete Course',
            'create latihanSoal',
            'view latihanSoal',
            'edit latihanSoal',
            'delete latihanSoal',
            'create Nilai',
            'view Nilai',
            'edit Nilai',
        ]);

        $siswaRole = Role::create([
            'name' => 'Siswa',
            'guard_name' => 'web', 
        ]);

        $siswaRole->givePermissionTo([
            'view Course',
            'view latihanSoal', 
            'view Nilai',
            'view Kelas',
            'view Kurikulum',
            'view Mapel',
        ]);


        // Membuat akun Admin
        $user = User::create([
            'name' => 'Kelompok6',
            'email' => 'Kelompok6@gmail.com',
            'password' => bcrypt('kelompok6'),
        ]);

        $user->assignRole($adminRole);

    }
}
