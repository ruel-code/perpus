<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '081234567890',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Satu',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('petugas123'),
            'phone_number' => '081234567891',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('mhs123'),
            'nim' => '220101001',
            'phone_number' => '081234567892',
            'study_program' => 'Teknik Informatika',
            'address' => 'Jl. Pendidikan No. 45, Bandung',
            'role' => 'user',
        ]);
    }
}
