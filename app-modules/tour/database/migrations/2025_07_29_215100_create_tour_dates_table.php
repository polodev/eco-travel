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
        Schema::create('tour_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->date('start_date'); // Tour start date
            $table->date('end_date'); // Tour end date
            $table->decimal('price_per_person', 10, 2); // Price per person for this date
            $table->decimal('child_price', 10, 2)->nullable(); // Child price for this date
            $table->decimal('single_supplement', 10, 2)->default(0.00); // Single room supplement
            $table->integer('available_spots'); // Total available spots
            $table->integer('booked_spots')->default(0); // Currently booked spots
            $table->integer('min_participants')->default(1); // Minimum required participants
            $table->enum('status', ['available', 'limited', 'fully_booked', 'cancelled', 'completed'])->default('available');
            $table->string('tour_guide')->nullable(); // Assigned tour guide
            $table->json('seasonal_adjustments')->nullable(); // Price adjustments
            $table->json('special_offers')->nullable(); // Discounts or promotions
            $table->text('special_notes')->nullable(); // Date-specific notes
            $table->boolean('is_peak_season')->default(false); // Peak season indicator
            $table->boolean('is_guaranteed')->default(false); // Guaranteed departure
            $table->datetime('booking_deadline')->nullable(); // Last booking date
            $table->datetime('cancellation_deadline')->nullable(); // Last cancellation date
            $table->decimal('deposit_amount', 10, 2)->nullable(); // Required deposit
            $table->integer('deposit_percentage')->nullable(); // Deposit as percentage
            $table->json('weather_info')->nullable(); // Expected weather conditions
            $table->json('local_events')->nullable(); // Special local events during tour
            $table->timestamps();
            
            $table->index(['tour_id', 'start_date']);
            $table->index('status');
            $table->index('is_guaranteed');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_dates');
    }
};