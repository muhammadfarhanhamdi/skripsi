<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@klinik.com',
        ], [
            'name' => 'Admin Klinik',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
