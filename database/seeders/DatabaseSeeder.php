<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->call([
            CategorySeeder::class, // Jalankan CategorySeeder terlebih dahulu
            MemberSeeder::class,
            BookSeeder::class,
            UserSeeder::class,
            DuedateSeeder::class,
        ]);
    }
}