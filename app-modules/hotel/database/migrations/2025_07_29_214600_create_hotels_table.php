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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->text('address');
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->enum('star_rating', [1, 2, 3, 4, 5])->default(3);
            $table->json('amenities')->nullable(); // ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'parking', 'airport_shuttle']
            $table->json('images')->nullable(); // Array of image URLs
            $table->time('checkin_time')->default('14:00');
            $table->time('checkout_time')->default('11:00');
            $table->json('policies')->nullable(); // Hotel policies
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0.00); // User ratings average
            $table->integer('total_reviews')->default(0);
            $table->decimal('distance_from_airport', 5, 2)->nullable(); // Distance in KM
            $table->decimal('distance_from_city_center', 5, 2)->nullable(); // Distance in KM
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['country_id', 'city_id']);
            $table->index(['is_active', 'is_featured']);
            $table->index(['star_rating', 'average_rating']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};