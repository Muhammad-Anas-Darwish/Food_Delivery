<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodCart>
 */
class FoodCartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => $this->faker->randomElement(Cart::pluck('id')),
            'food_id' => $this->faker->randomElement(Food::pluck('id')),
            'quantity' => $this->faker->randomNumber(),
        ];
    }
}
