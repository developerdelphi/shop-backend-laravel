<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'slug' => $this->faker->slug(),
          'name' => $this->faker->sentence(4),
          'description' => $this->faker->paragraph(3, true),
          'price' => $this->faker->randomFloat(2, 0, 9999),
          'status' => 'active',
          'created_at' => now(),
        ];
    }
}
