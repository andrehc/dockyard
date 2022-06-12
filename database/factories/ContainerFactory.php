<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Container>
 */
class ContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'locator' => strtoupper($this->faker->unique()->bothify('?##')),
            'length' => config('constants.container.length'),
            'width' => config('constants.container.width'),
            'height' => config('constants.container.height'),
            'max_load_weight' => config('constants.container.max_load_weight'),
            'tare_weight' => config('constants.container.tare_weight')
        ];
    }

    public function oversized()
    {
        return $this->state(function (array $attributes) {
            return [
                'length' => $attributes['length'] + 400,
                'width' => $attributes['width'] + 510,
                'height' => $attributes['height'] + 310,
            ];
        });
    }
}
