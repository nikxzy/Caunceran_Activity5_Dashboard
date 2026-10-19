<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
    $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
    $name = $this->faker->unique()->words(2, true);

    return [ 
        'category_id' => $category->id,
        'category' => $category->name,
        'name' => $name, 
        'description' => $this->faker->sentence(), 
        'price' => $this->faker->randomFloat(2, 100, 5000), 
        'quantity' => $this->faker->numberBetween(1, 100), 
        'status' => 'Available', 
    ]; 
}
    
}
