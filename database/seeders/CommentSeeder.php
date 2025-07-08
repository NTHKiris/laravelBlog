<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
        if($users->count() > 0 && $posts->count() > 0  ){
            Comment::factory(10)->create([
                'user_id' => function() use ($users){
                     return $users->random()->id;
                } ,
                'post_id'=> function() use ($posts) {
                    return $posts->random()->id;
                }
            ]);
        }
        
    }
}
