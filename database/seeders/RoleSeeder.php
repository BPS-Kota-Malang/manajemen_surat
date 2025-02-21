<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        DB::table('roles')->insert([
            [
                'role' => 'Kepala BPS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'Kasubag',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'Operator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'Pegawai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
