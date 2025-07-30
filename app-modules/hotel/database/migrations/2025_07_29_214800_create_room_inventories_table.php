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
        Schema::create('room_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_room_id')->constrained('hotel_rooms')->onDelete('cascade');
            $table->date('date'); // Specific date for inventory
            $table->integer('total_rooms'); // Total rooms available for this type on this date
            $table->integer('available_rooms'); // Available rooms (not booked)
            $table->integer('booked_rooms')->default(0); // Booked rooms
            $table->integer('blocked_rooms')->default(0); // Blocked for maintenance, etc.
            $table->decimal('price', 10, 2); // Dynamic price for this date
            $table->decimal('discount_percentage', 5, 2)->default(0.00); // Discount if any
            $table->decimal('final_price', 10, 2); // Final price after discount
            $table->boolean('is_available')->default(true); // Available for booking
            $table->enum('rate_plan', ['room_only', 'standard', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'])->default('room_only');
            $table->json('inclusions')->nullable(); // What's included in the rate
            $table->integer('minimum_stay')->default(1); // Minimum nights stay
            $table->integer('maximum_stay')->nullable(); // Maximum nights stay
            $table->boolean('stop_sell')->default(false); // Stop selling flag
            $table->text('notes')->nullable(); // Special notes or restrictions
            $table->timestamps();
            
            $table->index(['hotel_room_id', 'date']);
            $table->index(['date', 'is_available']);
            $table->index(['price', 'final_price']);
            
            // Unique constraint on room + date
            $table->unique(['hotel_room_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_inventories');
    }
};