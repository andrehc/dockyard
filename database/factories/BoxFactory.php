<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Box>
 */
class BoxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'length' => $this->faker->numberBetween(10, 500),
            'width' => $this->faker->numberBetween(10, 500),
            'height' => $this->faker->numberBetween(10, 500),
            'weight' => $this->faker->numberBetween(1200, 200000)
        ];
    }
}
