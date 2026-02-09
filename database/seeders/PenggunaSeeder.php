<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'divisi' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // [
            //     'name' => 'Pimpinan 1',
            //     'email' => 'pimpinan1@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Pimpinan',
            //     'divisi' => 'Management',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Pimpinan 2',
            //     'email' => 'pimpinan2@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Pimpinan',
            //     'divisi' => 'Marketing',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 1',
            //     'email' => 'staff1@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'IT',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 2',
            //     'email' => 'staff2@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'HR',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 3',
            //     'email' => 'staff3@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'Keuangan',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 4',
            //     'email' => 'staff4@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'Marketing',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 5',
            //     'email' => 'staff5@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'IT',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            // [
            //     'name' => 'Staff 6',
            //     'email' => 'staff6@example.com',
            //     'password' => Hash::make('password123'),
            //     'role' => 'Staff',
            //     'divisi' => 'HR',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ],
            [
                'name' => 'Admin',
                'email' => 'adminid@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'Staff',
                'divisi' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
