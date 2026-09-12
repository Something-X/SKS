<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Mirrorless', 'icon' => '📷', 'sort_order' => 1],
            ['name' => 'DSLR', 'icon' => '📸', 'sort_order' => 2],
            ['name' => 'Lensa', 'icon' => '🔭', 'sort_order' => 3],
            ['name' => 'Drone', 'icon' => '🚁', 'sort_order' => 4],
            ['name' => 'Lighting', 'icon' => '💡', 'sort_order' => 5],
            ['name' => 'Aksesoris', 'icon' => '🎒', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'sort_order' => $category['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
