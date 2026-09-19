<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Product;
use App\Services\GoogleSheetService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingForm extends Component
{
    public Product $product;

    public $start_date;

    public $end_date;

    public $pickup_time;

    public $customer_name;

    public $wa_number;

    public $notes;

    public $payment_method = 'PAY_AT_STORE';

    public $agree_terms = false;

    public $total_days = 0;

    public $total_price = 0;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);

            if ($end->greaterThanOrEqualTo($start)) {
                $this->total_days = $start->diffInDays($end) + 1;
                $this->total_price = $this->total_days * $this->product->price_per_day;
            } else {
                $this->total_days = 0;
                $this->total_price = 0;
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'wa_number' => 'required|numeric',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_time' => 'required',
            'agree_terms' => 'accepted',
        ]);

        // Cek bentrok jadwal booking
        $conflict = Booking::where('product_id', $this->product->id)
            ->where('status', '!=', 'Cancelled')
            ->where(function ($q) {
                $q->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date]);
            })->exists();

        if ($conflict) {
            $this->addError('start_date', 'Kamera sudah di-booking orang lain pada rentang tanggal tersebut.');

            return;
        }

        $bookingCode = 'SKS-'.strtoupper(Str::random(6));

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'customer_name' => $this->customer_name,
            'wa_number' => $this->wa_number,
            'product_id' => $this->product->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'pickup_time' => $this->pickup_time,
            'total_days' => $this->total_days,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
            'payment_method' => $this->payment_method,
            'status' => 'Pending',
        ]);

        // Kirim data booking ke Google Sheets
        try {
            app(GoogleSheetService::class)->appendBooking([
                'booking_code' => $booking->booking_code,
                'customer_name' => $booking->customer_name,
                'wa_number' => $booking->wa_number,
                'product_name' => $this->product->name,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'pickup_time' => $booking->pickup_time,
                'total_days' => $booking->total_days,
                'total_price' => $booking->total_price,
                'payment_method' => $booking->payment_method,
                'notes' => $booking->notes ?? '',
                'status' => $booking->status,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            Log::error('Google Sheets sync failed: '.$e->getMessage());
        }

        // Redirect ke halaman sukses membawa kode booking
        return redirect()->route('booking.success', $booking->booking_code);
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
