<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)
            ->has(Profile::factory(),'profile')
            ->create(); 
        User::doesntHave('profile')->limit(3)->get()->each( function ($user){
            Profile::factory()->create([
                'user_id' => $user->id
            ]);
        });
    }
}
