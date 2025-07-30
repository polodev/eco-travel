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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->string('flight_number'); // e.g., "BG147"
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $table->time('departure_time'); // Scheduled departure time
            $table->time('arrival_time'); // Scheduled arrival time
            $table->integer('duration_minutes'); // Flight duration in minutes
            $table->enum('aircraft_type', ['boeing_737', 'boeing_777', 'airbus_a320', 'airbus_a330', 'dash_8', 'atr_72', 'other'])->default('other');
            $table->json('operating_days'); // Array of days ['monday', 'tuesday', etc.]
            $table->enum('flight_type', ['domestic', 'international', 'regional'])->default('domestic');
            $table->boolean('is_active')->default(true);
            $table->boolean('has_meal')->default(false);
            $table->boolean('has_wifi')->default(false);
            $table->boolean('has_entertainment')->default(false);
            $table->json('baggage_allowance')->nullable(); // {"cabin": "7kg", "checked": "20kg"}
            $table->decimal('base_price', 10, 2)->nullable(); // Base price for economy class
            $table->integer('total_seats')->default(180);
            $table->integer('economy_seats')->default(150);
            $table->integer('business_seats')->default(30);
            $table->integer('first_seats')->default(0);
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['airline_id', 'flight_number']);
            $table->index(['departure_airport_id', 'arrival_airport_id']);
            $table->index(['is_active', 'flight_type']);
            $table->index('departure_time');
            
            // Unique constraint on airline + flight number
            $table->unique(['airline_id', 'flight_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};