<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            SettingSeeder::class,
            ProductSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@sewakamerasurabaya.com'],
            [
                'name' => 'Admin SKS',
                'password' => Hash::make('admin123'),
                'phone' => '081130899110',
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
