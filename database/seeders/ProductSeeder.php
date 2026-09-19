<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Nikon D5200', 'price' => 100000, 'file' => 'Nikon D5200.jpg'],
            ['name' => 'Nikon Fix 50mm f/1.8', 'price' => 45000, 'file' => 'Nikon Fix 50mm f/1.8.jpg'],
            ['name' => 'Canon EOS R100 Kit', 'price' => 150000, 'file' => 'Canon EOS R100 Kit.jpg'],
            ['name' => 'Canon EOS R100 + FIX 50mm', 'price' => 180000, 'file' => 'Canon EOS R100 + FIX 50mm.jpg'],
            ['name' => 'Canon EOS 1200D Kit', 'price' => 90000, 'file' => 'Canon EOS 1200D Kit.jpg'],
            ['name' => 'Canon EOS 1500D Kit', 'price' => 100000, 'file' => 'Canon EOS 1500D Kit.jpg'],
            ['name' => 'Canon EOS 200D Kit', 'price' => 130000, 'file' => 'Canon EOS 200D Kit.jpg'],
            ['name' => 'Canon EOS 60D Kit', 'price' => 120000, 'file' => 'Canon EOS 60D Kit.jpg'],
            ['name' => 'Canon EOS R50 Kit 15-45mm', 'price' => 200000, 'file' => 'Canon EOS R50 Kit 15-45mm.jpg'],
            ['name' => 'Canon Fix 50mm f/1.8 IIS', 'price' => 50000, 'file' => 'Canon Fix 50mm f/1.8 IIS.jpg'],
            ['name' => 'Canon Fix 50mm STM f/1.8', 'price' => 60000, 'file' => 'Canon Fix 50mm STM f/1.8.jpg'],
            ['name' => 'Canon Fix 24mm STM f/2.8', 'price' => 65000, 'file' => 'Canon Fix 24mm STM f/2.8.jpg'],
            ['name' => 'Canon Wide 10-18mm f/4.5 - 5.6', 'price' => 80000, 'file' => 'Canon Wide 10-18mm f/4.5 - 5.6 .jpg'],
            ['name' => 'Canon Wide 10-22mm f/3.5 - 4.5', 'price' => 85000, 'file' => 'Canon Wide 10-22mm f/3.5 - 4.5.jpg'],
            ['name' => 'Canon Tele RF 75-300 f/4-5.6', 'price' => 75000, 'file' => 'Canon Tele RF 75-300 f/4-5.6.jpg'],
        ];

        foreach ($items as $item) {
            // Deteksi otomatis ID Brand (1 = Canon, 2 = Nikon)
            $brandId = str_contains($item['name'], 'Nikon') ? 2 : 1;

            // Deteksi otomatis ID Kategori (1 = Kamera, 2 = Lensa)
            $isLens = str_contains($item['name'], 'Fix') || str_contains($item['name'], 'Wide') || str_contains($item['name'], 'Tele');
            $categoryId = $isLens ? 2 : 1;

            Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'price_per_day' => $item['price'],
                'thumbnail' => 'products/'.$item['file'], // Menggunakan 'thumbnail' sesuai migration Anda
                'is_active' => true,                        // Menggunakan 'is_active'
                'stock_quantity' => 1,
            ]);
        }
    }
}
