<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\EmergencyContact>
 */
class EmergencyContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'relation' => fake()->randomElement(['saudara', 'teman', 'tetangga', 'keluarga', 'anak', 'cucu']),
            'is_know' => fake()->boolean(),
            'address' => fake()->streetAddress(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
