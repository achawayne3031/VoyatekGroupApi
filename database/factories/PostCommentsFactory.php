<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComments>
 */
class PostCommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'editor' => fake()->name(),
            'post_id' => fake()->randomNumber(5),
            'comment' => fake()->sentence(100)
        ];
    }
}
