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
        Schema::create('booking_flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('flight_schedule_id')->constrained('flight_schedules')->onDelete('cascade');
            $table->enum('trip_type', ['oneway', 'roundtrip'])->default('oneway');
            $table->enum('cabin_class', ['economy', 'business', 'first'])->default('economy');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            $table->decimal('adult_price', 10, 2); // Price per adult
            $table->decimal('child_price', 10, 2)->nullable(); // Price per child
            $table->decimal('infant_price', 10, 2)->nullable(); // Price per infant
            $table->decimal('taxes_fees', 10, 2)->default(0.00); // Taxes and fees
            $table->decimal('total_price', 10, 2); // Total price for this flight
            $table->json('passenger_details'); // Passenger information
            $table->json('seat_selections')->nullable(); // Selected seats
            $table->json('meal_preferences')->nullable(); // Meal selections
            $table->json('special_requests')->nullable(); // Special assistance
            $table->string('pnr_code')->nullable(); // Airline PNR
            $table->string('ticket_numbers')->nullable(); // Issued ticket numbers
            $table->enum('ticket_status', ['pending', 'issued', 'cancelled', 'refunded'])->default('pending');
            $table->datetime('departure_datetime'); // Flight departure time
            $table->datetime('arrival_datetime'); // Flight arrival time
            $table->string('departure_airport'); // IATA code
            $table->string('arrival_airport'); // IATA code
            $table->string('airline_code'); // Airline IATA code
            $table->string('flight_number'); // Flight number
            $table->timestamps();
            
            $table->index(['booking_id', 'trip_type']);
            $table->index('departure_datetime');
            $table->index('pnr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_flights');
    }
};