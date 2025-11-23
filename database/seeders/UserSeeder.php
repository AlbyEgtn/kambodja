<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $ownerId = Role::where('nama', 'Owner')->first()->id;
        $kasirId = Role::where('nama', 'Kasir')->first()->id;
        $karyawanId = Role::where('nama', 'Karyawan')->first()->id;

        User::insert([
            [
                'nama_lengkap' => 'Owner Kedai',
                'username' => 'owner',
                'role_id' => $ownerId,
                'password' => hash('sha256', 'owner123'),
                'status' => 'aktif',
                'dibuat_pada' => now()
            ],
            [
                'nama_lengkap' => 'Kasir Utama',
                'username' => 'kasir',
                'role_id' => $kasirId,
                'password' => hash('sha256', 'kasir123'),
                'status' => 'aktif',
                'dibuat_pada' => now()
            ],
            [
                'nama_lengkap' => 'Karyawan Toko',
                'username' => 'karyawan',
                'role_id' => $karyawanId,
                'password' => hash('sha256', 'karyawan123'),
                'status' => 'aktif',
                'dibuat_pada' => now()
            ],
        ]);
    }
}
