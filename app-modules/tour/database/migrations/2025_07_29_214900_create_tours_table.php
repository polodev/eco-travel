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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tour name
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('description'); // Short description
            $table->longText('detailed_description')->nullable(); // Detailed description
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade'); // Destination country
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade'); // Destination city
            $table->integer('duration_days'); // Tour duration in days
            $table->integer('duration_nights'); // Tour duration in nights
            $table->enum('difficulty_level', ['easy', 'moderate', 'challenging', 'expert'])->default('easy');
            $table->enum('tour_type', ['cultural', 'adventure', 'wildlife', 'historical', 'religious', 'beach', 'city', 'nature'])->default('cultural');
            $table->integer('min_group_size')->default(1); // Minimum group size
            $table->integer('max_group_size')->default(20); // Maximum group size
            $table->decimal('base_price', 10, 2); // Base price per person
            $table->decimal('child_price', 10, 2)->nullable(); // Child price (if different)
            $table->decimal('single_supplement', 10, 2)->default(0.00); // Single room supplement
            $table->json('included_services'); // What's included (accommodation, meals, transport, etc.)
            $table->json('excluded_services')->nullable(); // What's not included
            $table->json('amenities')->nullable(); // Tour amenities/features
            $table->json('age_restrictions')->nullable(); // Age requirements
            $table->json('physical_requirements')->nullable(); // Physical fitness requirements
            $table->json('what_to_bring')->nullable(); // Items guests should bring
            $table->string('meeting_point')->nullable(); // Tour meeting point
            $table->time('meeting_time')->nullable(); // Tour meeting time
            $table->json('cancellation_policy'); // Cancellation terms
            $table->json('images')->nullable(); // Gallery images
            $table->string('featured_image')->nullable(); // Main tour image
            $table->decimal('rating', 2, 1)->default(0.0); // Average rating
            $table->integer('total_reviews')->default(0); // Total number of reviews
            $table->boolean('is_featured')->default(false); // Featured tour
            $table->boolean('is_active')->default(true); // Active status
            $table->enum('availability_status', ['available', 'limited', 'sold_out', 'suspended'])->default('available');
            $table->string('tour_operator')->nullable(); // Tour operator/guide company
            $table->string('contact_person')->nullable(); // Contact person name
            $table->string('contact_phone')->nullable(); // Contact phone
            $table->string('contact_email')->nullable(); // Contact email
            $table->json('pickup_locations')->nullable(); // Available pickup points
            $table->json('languages')->nullable(); // Available guide languages
            $table->text('special_notes')->nullable(); // Additional notes
            $table->timestamps();
            
            $table->index(['country_id', 'city_id']);
            $table->index('tour_type');
            $table->index('difficulty_level');
            $table->index('is_featured');
            $table->index('is_active');
            $table->index('availability_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};