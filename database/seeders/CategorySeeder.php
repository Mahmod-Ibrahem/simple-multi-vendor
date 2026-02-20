<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation check if needed or just create
        // Usually better to truncate if we are reseeding, matching LetterSeeder pattern
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $categories = [
            ['title' => ' مأكولات'],
            ['title' => 'حرف يدوية'],
            ['title' => 'تصاميم'],
            ['title' => 'أخري'],

        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
