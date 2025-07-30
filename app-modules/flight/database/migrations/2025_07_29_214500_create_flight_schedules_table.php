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
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->date('flight_date'); // Specific date for this flight instance
            $table->datetime('scheduled_departure'); // Actual scheduled departure datetime
            $table->datetime('scheduled_arrival'); // Actual scheduled arrival datetime
            $table->datetime('actual_departure')->nullable(); // Actual departure time (for completed flights)
            $table->datetime('actual_arrival')->nullable(); // Actual arrival time (for completed flights)
            $table->enum('status', ['scheduled', 'delayed', 'cancelled', 'departed', 'arrived', 'diverted'])->default('scheduled');
            $table->integer('delay_minutes')->default(0); // Delay in minutes
            $table->string('gate')->nullable(); // Departure gate
            $table->string('terminal')->nullable(); // Departure terminal
            $table->decimal('economy_price', 10, 2)->nullable(); // Dynamic pricing for economy
            $table->decimal('business_price', 10, 2)->nullable(); // Dynamic pricing for business
            $table->decimal('first_price', 10, 2)->nullable(); // Dynamic pricing for first class
            $table->integer('available_economy_seats'); // Available seats for economy
            $table->integer('available_business_seats'); // Available seats for business
            $table->integer('available_first_seats'); // Available seats for first class
            $table->integer('booked_seats')->default(0); // Total booked seats
            $table->boolean('is_available_for_booking')->default(true);
            $table->json('meal_options')->nullable(); // Available meal options
            $table->text('notes')->nullable(); // Additional notes or announcements
            $table->timestamps();
            
            $table->index(['flight_id', 'flight_date']);
            $table->index(['flight_date', 'status']);
            $table->index(['scheduled_departure', 'scheduled_arrival']);
            $table->index(['is_available_for_booking', 'flight_date']);
            
            // Unique constraint on flight + date
            $table->unique(['flight_id', 'flight_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_schedules');
    }
};