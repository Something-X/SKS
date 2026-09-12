<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class WhatsAppService
{
    /**
     * Generate WhatsApp booking message.
     */
    public function generateBookingMessage(Booking $booking): string
    {
        $items = '';
        foreach ($booking->items as $item) {
            $productName = $item->product->name ?? 'Produk';
            $pricePerDay = number_format($item->price_per_day, 0, ',', '.');
            $items .= "- {$productName} (Rp{$pricePerDay}/hari)\n";
        }
        
        $firstItem = $booking->items->first();
        $startDate = $firstItem ? Carbon::parse($firstItem->start_date)->format('d/m/Y') : '-';
        $endDate = $firstItem ? Carbon::parse($firstItem->end_date)->format('d/m/Y') : '-';
        $totalDays = $firstItem ? $firstItem->total_days : 0;
        
        $totalPrice = number_format($booking->total_amount, 0, ',', '.');
        $pickupTime = Carbon::parse($booking->pickup_time)->format('d/m/Y H:i');

        return <<<TEXT
🎬 *RESERVASI SEWA KAMERA*
━━━━━━━━━━━━━━━━━━━━━

📋 *Kode Booking:* {$booking->booking_code}
👤 *Nama:* {$booking->customer_name}
📱 *WhatsApp:* {$booking->customer_whatsapp}

📦 *Detail Sewa:*
{$items}
📅 *Periode:* {$startDate} s/d {$endDate} ({$totalDays} hari)
⏰ *Pengambilan:* {$pickupTime}
💰 *Total:* Rp{$totalPrice}
💳 *Pembayaran:* {$booking->payment_method}

📍 *Lokasi Pengambilan:*
Sewa Kamera Surabaya (SKS)
Prapen Indah blok S8

⚠️ Wajib membawa KTP/SIM asli saat pengambilan.
TEXT;
    }

    /**
     * Get WhatsApp URL.
     */
    public function getWhatsAppUrl(Booking $booking, ?string $adminNumber = null): string
    {
        $adminNumber = $adminNumber ?? Setting::get('admin_whatsapp_1');
        
        if (str_starts_with($adminNumber, '0')) {
            $adminNumber = '62' . substr($adminNumber, 1);
        }
        
        $message = urlencode($this->generateBookingMessage($booking));
        
        return "https://wa.me/{$adminNumber}?text={$message}";
    }
}
