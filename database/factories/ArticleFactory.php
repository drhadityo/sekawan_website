<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(2, 3),
            'title' => fake()->realTextBetween(20, 40),
            'img' => fake()->imageUrl(600, 400, fake()->randomElement(['virus', 'activity', 'article']), true),
            'contents' => fake()->realTextBetween(1000, 5000),
            'category_id' => fake()->numberBetween(1, 3),
            // 'deleted_at' => fake()->randomElement([null, fake()->date()]),
        ];
    }
}
