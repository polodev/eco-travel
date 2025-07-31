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
        Schema::create('booking_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id');
            $table->foreignId('tour_id');
            $table->date('tour_start_date'); // Tour start date
            $table->date('tour_end_date'); // Tour end date
            $table->integer('adults')->default(1); // Number of adults
            $table->integer('children')->default(0); // Number of children
            $table->decimal('adult_price', 10, 2); // Price per adult
            $table->decimal('child_price', 10, 2)->nullable(); // Price per child
            $table->decimal('single_supplement', 10, 2)->default(0.00); // Single room supplement
            $table->decimal('total_amount', 10, 2); // Total tour amount
            $table->json('participant_details'); // Participant information
            $table->string('accommodation_type')->default('shared'); // 'shared', 'single', 'twin', 'double'
            $table->json('dietary_requirements')->nullable(); // Dietary restrictions
            $table->json('medical_conditions')->nullable(); // Medical information
            $table->json('emergency_contacts'); // Emergency contact details
            $table->json('special_requests')->nullable(); // Special requests
            $table->json('optional_activities')->nullable(); // Booked optional activities
            $table->string('tour_voucher')->nullable(); // Tour operator voucher
            $table->string('booking_status')->default('pending'); // 'pending', 'confirmed', 'in_progress', 'completed', 'cancelled'
            $table->string('tour_guide')->nullable(); // Assigned tour guide
            $table->json('pickup_details')->nullable(); // Pickup location and time
            $table->text('tour_inclusions')->nullable(); // What's included
            $table->text('tour_exclusions')->nullable(); // What's not included
            $table->json('what_to_bring')->nullable(); // Items to bring
            $table->datetime('confirmed_at')->nullable(); // When confirmed by tour operator
            $table->timestamps();
            
            $table->index(['booking_id', 'tour_id']);
            $table->index(['tour_start_date', 'tour_end_date']);
            $table->index('tour_voucher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_tours');
    }
};