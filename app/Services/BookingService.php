<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingService
{
    public function __construct() {}

    /**
     * Generate unique booking code.
     */
    public function generateBookingCode(): string
    {
        $date = now()->format('Ymd');

        do {
            $random = strtoupper(Str::random(4));
            $code = "BK-{$date}-{$random}";
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Create from cart data.
     *
     * @param  array<int, array<string, mixed>>  $cartItems
     * @param  array<string, mixed>  $customerData
     */
    public function createFromCart(array $cartItems, array $customerData): Booking
    {
        return DB::transaction(function () use ($cartItems, $customerData) {
            $totalAmount = 0;

            foreach ($cartItems as $item) {
                $totalAmount += $item['subtotal'];
            }

            $booking = Booking::create([
                'booking_code' => $this->generateBookingCode(),
                'customer_name' => $customerData['customer_name'],
                'customer_whatsapp' => $customerData['customer_whatsapp'],
                'customer_email' => $customerData['customer_email'] ?? null,
                'notes' => $customerData['notes'] ?? null,
                'pickup_time' => $customerData['pickup_time'],
                'payment_method' => $customerData['payment_method'],
                'total_amount' => $totalAmount,
            ]);

            foreach ($cartItems as $item) {
                BookingItem::create([
                    'booking_id' => $booking->id,
                    'product_id' => $item['product_id'],
                    'start_date' => $item['start_date'],
                    'end_date' => $item['end_date'],
                    'price_per_day' => $item['price_per_day'],
                    'total_days' => $item['total_days'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $booking;
        });
    }

    /**
     * Check availability.
     */
    public function checkAvailability(int $productId, string $startDate, string $endDate): bool
    {
        $overlappingBookings = BookingItem::where('product_id', $productId)
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['confirmed', 'picked_up']);
            })
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
            })
            ->exists();

        return ! $overlappingBookings;
    }

    /**
     * Get booked dates for a product.
     *
     * @return array<int, array<string, string>>
     */
    public function getBookedDates(int $productId): array
    {
        return BookingItem::where('product_id', $productId)
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['confirmed', 'picked_up']);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'start' => Carbon::parse($item->start_date)->format('Y-m-d'),
                    'end' => Carbon::parse($item->end_date)->format('Y-m-d'),
                ];
            })
            ->toArray();
    }

    /**
     * Generate QR code for a booking.
     */
    public function generateQrCode(Booking $booking): string
    {
        $code = $booking->booking_code;
        $path = "qrcodes/{$code}.png";

        $qrCodeData = "Booking Code: {$code}\nCustomer: {$booking->customer_name}\nTotal: {$booking->total_amount}";

        $fullDirectory = storage_path('app/public/qrcodes');
        if (! file_exists($fullDirectory)) {
            mkdir($fullDirectory, 0755, true);
        }

        QrCode::format('png')
            ->size(300)
            ->generate($qrCodeData, storage_path("app/public/{$path}"));

        return $path;
    }
}
