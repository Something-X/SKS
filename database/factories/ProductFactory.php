<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(2, true),
            'price_per_day' => fake()->randomElement([75000, 100000, 150000, 200000, 250000, 350000, 500000]),
            'deposit_amount' => 0,
            'stock_quantity' => fake()->numberBetween(1, 3),
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
        ];
    }
}
