<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = \App\Models\Car::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(2),
            'name' => $this->faker->words(2, true),
            'desc' => $this->faker->sentence(),
            'fee' => '$' . $this->faker->numberBetween(100, 999),
            'image' => null,
            'category' => $this->faker->word(),
            'badge' => $this->faker->word(),
            'power' => $this->faker->sentence(),
            'range' => $this->faker->sentence(),
            'delivery' => $this->faker->sentence(),
            'gradient' => 'from-gray-900 to-gray-800',
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
