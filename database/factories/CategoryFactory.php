<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['Mirrorless', 'DSLR', 'Lensa', 'Drone', 'Lighting', 'Aksesoris']);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => '📷',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
