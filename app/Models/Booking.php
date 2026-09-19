<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'booking_code', 'customer_name', 'customer_whatsapp', 'customer_email', 'notes',
    'pickup_time', 'start_date', 'end_date', 'total_days', 'subtotal', 'total_price',
    'payment_method', 'payment_status', 'booking_status', 'confirmed_at',
    'picked_up_at', 'returned_at', 'cancelled_at', 'cancellation_reason', 'qr_code_path',
])]
class Booking extends Model
{
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'confirmed_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'returned_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function markAsConfirmed(): void
    {
        $this->update([
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function markAsPickedUp(): void
    {
        $this->update([
            'booking_status' => 'picked_up',
            'picked_up_at' => now(),
        ]);
    }

    public function markAsReturned(): void
    {
        $this->update([
            'booking_status' => 'returned',
            'returned_at' => now(),
        ]);
    }

    public function cancel(string $reason): void
    {
        $this->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }
}
