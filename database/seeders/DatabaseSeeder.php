<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Hanya buat 1 admin default
        User::firstOrCreate(
            ['email' => 'admin@kampus.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // bisa diganti nanti kalau mau
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
