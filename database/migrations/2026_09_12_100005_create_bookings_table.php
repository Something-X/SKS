<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 16)->unique();
            $table->string('customer_name');
            $table->string('customer_whatsapp', 20);
            $table->string('customer_email')->nullable();
            $table->text('notes')->nullable();
            $table->string('pickup_time')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->enum('payment_method', ['dp_transfer', 'full_at_store']);
            $table->enum('payment_status', ['pending', 'dp_paid', 'paid', 'refunded']);
            $table->enum('booking_status', ['pending', 'confirmed', 'picked_up', 'returned', 'cancelled']);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->timestamps();

            $table->index('booking_code');
            $table->index('booking_status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
