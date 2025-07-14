<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $writers = User::whereHas('role', function ($q) {
            $q->where('slug', 'admin')->orWhere('slug', 'writer');
        })->get();

        $categories = Category::all();
        foreach ($writers as $writer) {
            $postCount = rand(3, 10);
            Post::factory($postCount)->create([
                'user_id' => $writer->id,
                'category_id' => $categories->random()->id
            ]);
        }
    }
}
