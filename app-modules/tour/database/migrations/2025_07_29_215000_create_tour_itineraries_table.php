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
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->integer('day_number'); // Day number in itinerary
            $table->string('day_title'); // Day title (e.g., "Arrival in Dhaka")
            $table->text('day_description'); // Detailed day description
            $table->json('activities'); // List of activities for the day
            $table->json('meals_included')->nullable(); // Breakfast, Lunch, Dinner
            $table->string('accommodation')->nullable(); // Where guests stay this night
            $table->string('accommodation_type')->nullable(); // Hotel, Resort, Camping, etc.
            $table->integer('accommodation_rating')->nullable(); // Star rating
            $table->string('location')->nullable(); // Location/city for this day
            $table->time('start_time')->nullable(); // Day start time
            $table->time('end_time')->nullable(); // Day end time
            $table->json('transportation')->nullable(); // Transportation details
            $table->decimal('estimated_distance', 8, 2)->nullable(); // Distance covered (km)
            $table->integer('estimated_duration')->nullable(); // Duration in minutes
            $table->json('optional_activities')->nullable(); // Optional paid activities
            $table->json('meal_options')->nullable(); // Meal choices/dietary options
            $table->text('special_notes')->nullable(); // Special instructions
            $table->json('images')->nullable(); // Day-specific images
            $table->boolean('is_rest_day')->default(false); // If it's a rest/free day
            $table->integer('sort_order')->default(0); // Custom ordering
            $table->timestamps();
            
            $table->index(['tour_id', 'day_number']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_itineraries');
    }
};