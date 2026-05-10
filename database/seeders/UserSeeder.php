<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas Satu',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('mhs123'),
            'nim' => '220101001',
            'role' => 'mahasiswa',
        ]);
    }
}
