<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $teachers = Teacher::all();
        $posts = Post::all();

        foreach ($users as $user) {
            $user->images()->create([
                'url' => fake()->imageUrl(300, 300)
            ]);
        }
        foreach ($posts->take(10) as $post) {
            $post->image()->create([
                'url' => fake()->imageUrl(800, 600)
            ]);
        }
        foreach ($teachers->take(5) as $teacher) {
            $teacher->image()->create([
                'url' => fake()->imageUrl(300, 300)
            ]);
        }

    }
}
