<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();

        if($users->count()>0 && $categories->count() > 0) {
            Post::factory(10)->create([
                'category_id' => function() use ($categories) {
                    return $categories->random()->id;
                },
                'user_id' => function() use ($users) {
                    return $users->random()->id;
                }
            ]);
        } else {
            Post::factory(10)->create();    
        }   
    }
}
