<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\OrderAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'address_id' => $this->faker->randomElement(OrderAddress::pluck('id')),
            'cart_id' => $this->faker->randomElement(Cart::pluck('id')),
            'has_been_received' => $this->faker->boolean(),
            'total' => $this->faker->numberBetween(5000, 300000),
        ];
    }
}
