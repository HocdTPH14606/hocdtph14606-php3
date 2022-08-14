<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order_details>
 */
class Order_detailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [ 
            'product_name' => $this->faker->text(50),  
            'product_price' => $this->faker->numberBetween($min = 100000, $max = 1000000000),
            'Total_money' => $this->faker->numberBetween($min = 100000, $max = 1000000000),
            'amount' => rand(1, 100), 
            'order_id' => rand(1, 100), 
            'product_id' => rand(1, 5), 
            'product_img' => $this->faker->imageUrl(),
        ]; 
    }
}
