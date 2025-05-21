<?php

namespace Database\Seeders;

use App\Models\DueDateMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DuedateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DueDateMaster::create([
            'due_date' => '2025-06-01',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DueDateMaster::create([
            'due_date' => '2025-05-30',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
