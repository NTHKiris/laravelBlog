<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
            ],
            [
                'name' => 'Food & Cooking',
                'slug' => 'food-cooking',
            ],
            [
                'name' => 'Health & Fitness',
                'slug' => 'health-fitness',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
            ],
            [
                'name' => 'Science',
                'slug' => 'science',
            ],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
