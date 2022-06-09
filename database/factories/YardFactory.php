<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Yard>
 */
class YardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'locator' => strtoupper($this->faker->lexify('???')),
            'length' => 606*$this->faker->randomDigitNotNull(),
            'width' => 244*$this->faker->randomDigitNotNull(),
        ];
    }
}