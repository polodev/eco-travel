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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique(); // e.g., ECO-2025-001234
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('booking_type', ['flight', 'hotel', 'tour', 'package']); // Type of booking
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'refunded'])->default('pending');
            $table->decimal('total_amount', 10, 2); // Total booking amount
            $table->decimal('paid_amount', 10, 2)->default(0.00); // Amount paid
            $table->decimal('due_amount', 10, 2)->default(0.00); // Remaining amount
            $table->json('customer_details'); // Customer information
            $table->json('contact_details'); // Contact information
            $table->json('additional_requirements')->nullable(); // Special requests
            $table->datetime('booking_date'); // When booking was made
            $table->datetime('travel_date')->nullable(); // When travel starts
            $table->datetime('return_date')->nullable(); // When travel ends
            $table->integer('adults')->default(1); // Number of adults
            $table->integer('children')->default(0); // Number of children
            $table->integer('infants')->default(0); // Number of infants
            $table->json('cancellation_policy')->nullable(); // Cancellation terms
            $table->text('notes')->nullable(); // Internal notes
            $table->string('payment_status')->default('pending'); // pending, partial, paid, refunded
            $table->string('confirmation_code')->nullable(); // Confirmation from supplier
            $table->datetime('confirmed_at')->nullable(); // When booking was confirmed
            $table->datetime('cancelled_at')->nullable(); // When booking was cancelled
            $table->string('cancelled_by')->nullable(); // Who cancelled (customer, admin, system)
            $table->text('cancellation_reason')->nullable(); // Reason for cancellation
            $table->timestamps();
            
            $table->index(['user_id', 'booking_type']);
            $table->index(['status', 'booking_date']);
            $table->index('booking_reference');
            $table->index('travel_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};