<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialist>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'specialist_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 100),  
        ];
    }
}
