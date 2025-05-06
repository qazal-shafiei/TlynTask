<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement(['buy', 'sell']),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([Order::STATUS_PENDING, Order::STATUS_COMPLETED, Order::STATUS_CANCELLED]),
        ];
    }

    /**
     * State for buy orders.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function buy()
    {
        return $this->state([
            'type' => 'buy',
        ]);
    }

    /**
     * State for sell orders.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function sell()
    {
        return $this->state([
            'type' => 'sell',
        ]);
    }
}
