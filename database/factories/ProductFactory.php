<?php

namespace Database\Factories;

use App\Models\Product; // Replace with your actual model name
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'section_id' => $this->faker->numberBetween(1, 10), // Adjust the range based on the number of sections in your database
            'price' => $this->faker->randomFloat(2, 1, 10000),
            'discount' => $this->faker->numberBetween(0, 99), // Create some products with and without discount
            'delivery_price' => $this->faker->optional()->randomFloat(2, 0, 1000), // Create some products with and without delivery price
            'delivery_time' => $this->faker->randomNumber(2) . ' days', // Optional delivery time format
            'details' => $this->faker->paragraph(2), // Generate some product details
            'rating' => $this->faker->numberBetween(0, 5), // Optional rating format
            'number_of_ratings' => $this->faker->optional()->randomNumber(), // Optional number of ratings
            'number_of_sales' => $this->faker->optional()->randomNumber(4), // Optional number of sales
            'quantity' => $this->faker->optional()->randomNumber(), // Optional product quantity
            'specifications' => $this->faker->text(200), // Generate some product specifications
        ];
    }
}
