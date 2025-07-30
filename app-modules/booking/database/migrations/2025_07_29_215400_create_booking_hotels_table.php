<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('hotel_room_id')->constrained('hotel_rooms')->onDelete('cascade');
            $table->date('checkin_date'); // Check-in date
            $table->date('checkout_date'); // Check-out date
            $table->integer('nights'); // Number of nights
            $table->integer('rooms')->default(1); // Number of rooms
            $table->integer('adults')->default(2); // Adults per room
            $table->integer('children')->default(0); // Children per room
            $table->decimal('room_rate', 10, 2); // Rate per room per night
            $table->decimal('total_room_cost', 10, 2); // Total cost for rooms
            $table->decimal('taxes_fees', 10, 2)->default(0.00); // Hotel taxes
            $table->decimal('total_price', 10, 2); // Total price including taxes
            $table->json('guest_details'); // Guest information
            $table->enum('rate_plan', ['room_only', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'])->default('room_only');
            $table->json('room_preferences')->nullable(); // Room preferences
            $table->json('special_requests')->nullable(); // Special requests
            $table->string('confirmation_number')->nullable(); // Hotel confirmation
            $table->enum('booking_status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'no_show', 'cancelled'])->default('pending');
            $table->time('checkin_time')->nullable(); // Expected check-in time
            $table->time('checkout_time')->nullable(); // Expected check-out time
            $table->text('hotel_policies')->nullable(); // Hotel policies
            $table->json('included_services')->nullable(); // Included services
            $table->datetime('confirmed_at')->nullable(); // When confirmed by hotel
            $table->timestamps();
            
            $table->index(['booking_id', 'hotel_id']);
            $table->index(['checkin_date', 'checkout_date']);
            $table->index('confirmation_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_hotels');
    }
};