<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Novel', 'Teknologi', 'Pendidikan', 'Agama', 'Sejarah', 'Fiksi', 'Non-Fiksi', 'Referensi', 'Akademik'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
