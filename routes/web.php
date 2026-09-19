<?php

use App\Livewire\Admin\Product\Form as AdminProductForm;
use App\Livewire\Admin\Product\Index as AdminProductIndex;
use App\Livewire\Admin\Promo\Form as AdminPromoForm;
use App\Livewire\Admin\Promo\Index as AdminPromoIndex;
use App\Livewire\BookingForm;
use App\Livewire\Catalog;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::get('/', Catalog::class)->name('home');
Route::get('/sewa/{product:slug}', BookingForm::class)->name('product.book');

Route::get('/booking/success/{code}', function ($code) {
    $booking = Booking::with('product')->where('booking_code', $code)->firstOrFail();

    return view('booking-success', compact('booking'));
})->name('booking.success');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', AdminProductIndex::class)->name('products.index');
    Route::get('/products/create', AdminProductForm::class)->name('products.create');
    Route::get('/products/{product}/edit', AdminProductForm::class)->name('products.edit');

    Route::get('/promos', AdminPromoIndex::class)->name('promos.index');
    Route::get('/promos/create', AdminPromoForm::class)->name('promos.create');
    Route::get('/promos/{promo}/edit', AdminPromoForm::class)->name('promos.edit');
});
