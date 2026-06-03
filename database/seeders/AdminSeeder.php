<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Koperasi',
            'email' => 'admin@koperasi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Kantor Koperasi',
        ]);
    }
}