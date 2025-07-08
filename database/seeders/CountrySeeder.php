<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vietnam = Country::create(['name'=>'Vietnam','code'=>'VN']);
        $usa = Country::create(['name'=>'America', 'code' =>'US']);
        $japan = Country::create(['name'=>'Japan', 'code' =>'JP']);

        $tech = Category::create(['name'=>'Technology', 'slug'=>'technology']);
        $health = Category::create(['name'=>'Health','slug'=>'health']);
        $travel = Category::create(['name'=>'Travel','slug'=>'travel']);

        $vnUsers = User::factory(3)->create(['country_id' => $vietnam->id]);
        $usUsers = User::factory(2)->create(['country_id' => $usa->id]);
        $jpUsers = User::factory(2)->create(['country_id' => $japan->id]);

        $allUsers = $vnUsers->merge($usUsers)->merge($jpUsers);

        $allUsers->each(function ($user) use ($tech, $health, $travel) {
            Post::factory(rand(1, 3))->create([
                'user_id' => $user->id,
                'category_id' => collect([$tech->id, $health->id, $travel->id])->random()
            ]);
        });

        
        Post::all()->each(function ($post) use ($allUsers) {
            Comment::factory(rand(0, 3))->create([
                'post_id' => $post->id,
                'user_id' => $allUsers->random()->id
            ]);
        });
    }
}
