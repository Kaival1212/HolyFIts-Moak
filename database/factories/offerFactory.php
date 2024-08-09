<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class offerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->sentence(),
            'link' => $this->faker->url(),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
