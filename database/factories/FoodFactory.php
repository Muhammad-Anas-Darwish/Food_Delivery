<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'price' => $this->faker->numberBetween(5000, 70000),
            'is_active' => $this->faker->boolean(),
            'category_id' => $this->faker->randomElement(Category::pluck('id')),
            'description' => $this->faker->text(),
            'image' => $this->faker->image(),
        ];
    }
}
