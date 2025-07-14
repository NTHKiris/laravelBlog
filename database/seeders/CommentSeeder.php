<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        Comment::factory(150)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            },
            'post_id' => function () use ($posts) {
                return $posts->random()->id;
            }
        ]);
    }
}
