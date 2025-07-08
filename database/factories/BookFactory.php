<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->sentence(),
            'type'=>fake()->randomElement(['manga','novel','sience','news','document']),
            'price'=>fake()->numberBetween(20000,500000),
            'description'=>fake()->paragraph(),
            'author_id' => optional(Author::inRandomOrder()->first())->id

        ];
    }
}
