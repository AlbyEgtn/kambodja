<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::insert([
            ['nama' => 'Karyawan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kasir', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Owner', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
