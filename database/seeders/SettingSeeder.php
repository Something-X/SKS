<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'store_name' => 'Sewa Kamera Surabaya (SKS)',
            'store_address' => 'Prapen Indah blok S8',
            'store_maps_url' => 'https://share.google/5bgHD9kIg3LmJq2GS',
            'admin_whatsapp_1' => '6281130899110',
            'admin_whatsapp_2' => '6281790699110',
            'store_open_hours' => '09:00 - 21:00',
            'min_rental_days' => '1',
            'terms_conditions' => "Syarat & Ketentuan Sewa:\n1. Wajib membawa KTP/SIM asli saat pengambilan.\n2. Peralatan wajib dikembalikan dalam kondisi baik.\n3. Keterlambatan pengembalian dikenakan denda Rp50.000/jam.\n4. Kerusakan/kehilangan ditanggung penyewa sesuai harga pasar.\n5. Pembatalan H-1 dikenakan biaya 50% dari total sewa.",
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
