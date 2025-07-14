<?php

namespace Database\Factories;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => fake()->imageUrl(640, 480, null, true),
            'name' => fake()->word(),
            'type' => 'default',
            'imageable_id' => null,
            'imageable_type' => null
        ];
    }

    public function thumpnail()
    {
        return $this->state(function ($attributes) {
            return ['type' => 'thumpnail'];
        });
    }
    public function avatar()
    {
        return $this->state(function ($attributes) {
            return ['type' => 'avatar'];
        });
    }
}
