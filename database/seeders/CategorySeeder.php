<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'id'   => 1, // Pastikan ID sesuai dengan yang digunakan di BookSeeder
            'name' => 'Programming',
        ]);

        Category::create([
            'id'   => 2, // Pastikan ID sesuai dengan yang digunakan di BookSeeder
            'name' => 'Web Development',
        ]);
    }
}