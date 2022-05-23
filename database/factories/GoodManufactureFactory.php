<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GoodManufacture>
 */
class GoodManufactureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'good_id' => $this->faker->numberBetween(1,20),
            'manufacture_id' => $this->faker->numberBetween(1,20)
        ];
    }
}
