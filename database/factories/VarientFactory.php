<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Varient>
 */
class VarientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['size' , 'model' , 'colour']),
            'price' => fake()->numberBetween(10,100),
            'attributes' => fake()->randomLetter(),
             'image' => fake()->imageUrl(),
        ];
    }
}
