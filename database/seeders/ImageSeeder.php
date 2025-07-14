<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
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
        $posts = Post::all();


        foreach ($users as $user) {
            Image::factory()->avatar()->create([
                'imageable_id' => $user->id,
                'imageable_type' => User::class
            ]);
        }


        foreach ($posts as $post) {
            Image::factory()->thumpnail()->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class
            ]);
        }
    }
}
