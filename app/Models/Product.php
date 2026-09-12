<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['category_id', 'brand_id', 'name', 'slug', 'description', 'specifications', 'price_per_day', 'deposit_amount', 'stock_quantity', 'thumbnail', 'is_active', 'is_featured'])]
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'price_per_day' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function isAvailableBetween(string $startDate, string $endDate): bool
    {
        $bookedQuantity = $this->bookingItems()
            ->whereHas('booking', function (Builder $query) use ($startDate, $endDate) {
                $query->whereIn('booking_status', ['confirmed', 'picked_up'])
                    ->where(function (Builder $q) use ($startDate, $endDate) {
                        $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function (Builder $q2) use ($startDate, $endDate) {
                                $q2->where('start_date', '<=', $startDate)
                                    ->where('end_date', '>=', $endDate);
                            });
                    });
            })
            ->sum('quantity');

        return ($this->stock_quantity - $bookedQuantity) > 0;
    }

    public function getBookedDatesAttribute(): array
    {
        $bookings = $this->bookingItems()
            ->whereHas('booking', function (Builder $query) {
                $query->whereIn('booking_status', ['confirmed', 'picked_up']);
            })
            ->with('booking')
            ->get();

        $bookedDates = [];
        foreach ($bookings as $item) {
            $bookedDates[] = [
                'start' => $item->booking->start_date->format('Y-m-d'),
                'end' => $item->booking->end_date->format('Y-m-d'),
            ];
        }

        return $bookedDates;
    }
}
