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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('room_type'); // 'standard', 'deluxe', 'suite', 'presidential'
            $table->string('name'); // 'Standard Double Room', 'Deluxe Suite', etc.
            $table->text('description')->nullable();
            $table->integer('max_occupancy')->default(2); // Maximum guests
            $table->integer('max_adults')->default(2);
            $table->integer('max_children')->default(1);
            $table->decimal('room_size', 5, 2)->nullable(); // Room size in sqm
            $table->enum('bed_type', ['single', 'double', 'queen', 'king', 'twin', 'sofa_bed'])->default('double');
            $table->integer('bed_count')->default(1);
            $table->json('amenities')->nullable(); // ['ac', 'tv', 'wifi', 'minibar', 'safe', 'balcony', 'sea_view', 'city_view']
            $table->json('images')->nullable(); // Array of room image URLs
            $table->decimal('base_price', 10, 2); // Base price per night
            $table->boolean('is_active')->default(true);
            $table->boolean('is_refundable')->default(true);
            $table->json('cancellation_policy')->nullable(); // Cancellation terms
            $table->integer('total_rooms')->default(1); // Total rooms of this type
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['hotel_id', 'room_type']);
            $table->index(['is_active', 'base_price']);
            $table->index('max_occupancy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};