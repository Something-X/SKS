<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Carbon;

class CartService
{
    /**
     * Get all cart items.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getItems(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Add product to cart.
     */
    public function addItem(int $productId, string $startDate, string $endDate): void
    {
        $cart = $this->getItems();

        $product = Product::findOrFail($productId);

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $totalDays = $start->diffInDays($end) + 1;
        $subtotal = $product->price_per_day * $totalDays;

        $cart[$productId] = [
            'product_id' => $productId,
            'product_name' => $product->name,
            'product_thumbnail' => $product->thumbnail ?? '',
            'price_per_day' => $product->price_per_day,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'total_days' => $totalDays,
            'subtotal' => $subtotal,
            'quantity' => 1,
        ];

        session()->put('cart', $cart);
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $productId): void
    {
        $cart = $this->getItems();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }

    /**
     * Update dates for an item.
     */
    public function updateDates(int $productId, string $startDate, string $endDate): void
    {
        $cart = $this->getItems();

        if (isset($cart[$productId])) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            $totalDays = $start->diffInDays($end) + 1;
            $subtotal = $cart[$productId]['price_per_day'] * $totalDays;

            $cart[$productId]['start_date'] = $start->format('Y-m-d');
            $cart[$productId]['end_date'] = $end->format('Y-m-d');
            $cart[$productId]['total_days'] = $totalDays;
            $cart[$productId]['subtotal'] = $subtotal;

            session()->put('cart', $cart);
        }
    }

    /**
     * Get total of all items in cart.
     */
    public function getTotal(): float
    {
        $cart = $this->getItems();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        return (float) $total;
    }

    /**
     * Get item count.
     */
    public function getItemCount(): int
    {
        return count($this->getItems());
    }

    /**
     * Clear the cart.
     */
    public function clear(): void
    {
        session()->forget('cart');
    }

    /**
     * Check if cart is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->getItems());
    }
}
