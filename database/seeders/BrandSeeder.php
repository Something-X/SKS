<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Sony', 'Canon', 'Fujifilm', 'Nikon', 'DJI', 'GoPro', 'Panasonic'];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand],
                [
                    'slug' => Str::slug($brand),
                    'is_active' => true,
                ]
            );
        }
    }
}
