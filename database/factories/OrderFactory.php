<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [ 
            'email' => $this->faker->safeEmail(),    
            'address' => $this->faker->text(255), 
            'phone' => $this->faker->phoneNumber(),
            'price' => $this->faker->numberBetween($min = 100000, $max = 10000000),
            'note' => $this->faker->text(255), 
            'status' => rand(0, 2),
            'user_id' => rand(1, 5), 
        ];
    }
}
