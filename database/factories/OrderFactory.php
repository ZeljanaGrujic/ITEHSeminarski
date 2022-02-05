<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'order_status_id' => OrderStatus::all()->random()->id,
            'created_at' => $this->faker->dateTimeInInterval('-7 days', '+14 days')
        ];
    }
}
