<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['public','private', 'secret']);
        return [
            'name'=>fake()->sentence(),
            'description'=>fake()->paragraph(),
            'type'=>$type,
            'max_members'=> match($type) {
                'public' => 500,
                'private' =>200,
                'secret' =>50
            },
            'is_active'=>fake()->boolean()
        ];
    }
}
