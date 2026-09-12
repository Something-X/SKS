<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category' => 'Mirrorless', 'brand' => 'Sony', 'name' => 'Sony A7 III', 'price' => 250000],
            ['category' => 'Mirrorless', 'brand' => 'Sony', 'name' => 'Sony A7C II', 'price' => 300000],
            ['category' => 'Mirrorless', 'brand' => 'Fujifilm', 'name' => 'Fujifilm X-T5', 'price' => 200000],
            ['category' => 'Mirrorless', 'brand' => 'Canon', 'name' => 'Canon EOS R6 Mark II', 'price' => 275000],
            ['category' => 'DSLR', 'brand' => 'Canon', 'name' => 'Canon EOS 5D Mark IV', 'price' => 200000],
            ['category' => 'DSLR', 'brand' => 'Nikon', 'name' => 'Nikon D850', 'price' => 225000],
            ['category' => 'Lensa', 'brand' => 'Sony', 'name' => 'Sony FE 24-70mm f/2.8 GM II', 'price' => 150000],
            ['category' => 'Lensa', 'brand' => 'Canon', 'name' => 'Canon RF 70-200mm f/2.8L', 'price' => 175000],
            ['category' => 'Lensa', 'brand' => 'Sony', 'name' => 'Sony FE 85mm f/1.4 GM', 'price' => 125000],
            ['category' => 'Drone', 'brand' => 'DJI', 'name' => 'DJI Mavic 3 Pro', 'price' => 350000],
            ['category' => 'Drone', 'brand' => 'DJI', 'name' => 'DJI Mini 4 Pro', 'price' => 200000],
            ['category' => 'Lighting', 'brand' => 'GoPro', 'name' => 'Godox SL-60W (Pair)', 'price' => 100000], // Brand is specified as GoPro for this lighting per request
            ['category' => 'Aksesoris', 'brand' => 'GoPro', 'name' => 'GoPro Hero 12 Black', 'price' => 150000],
            ['category' => 'Aksesoris', 'brand' => 'DJI', 'name' => 'DJI RS 3 Gimbal', 'price' => 175000],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();
            $brand = Brand::where('name', $item['brand'])->first();

            if ($category && $brand) {
                Product::updateOrCreate(
                    ['name' => $item['name']],
                    [
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'slug' => Str::slug($item['name']),
                        'price_per_day' => $item['price'],
                        'deposit_amount' => 0,
                        'stock_quantity' => 2,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
