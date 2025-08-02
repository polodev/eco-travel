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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Reference to either booking or custom payment
            $table->foreignId('booking_id')->nullable();
            $table->foreignId('custom_payment_id')->nullable();
            
            // Who created this payment record
            $table->foreignId('created_by')->nullable(); // User ID of creator (admin/employee or auto-generated)
            
            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // 'pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'
            $table->string('payment_method')->nullable(); // 'sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer', 'cash', 'other'
            
            // Payment gateway information
            $table->string('transaction_id')->nullable(); // Gateway transaction ID
            $table->string('gateway_payment_id')->nullable(); // Payment ID sent to gateway
            $table->json('gateway_response')->nullable(); // Full gateway response
            $table->string('gateway_reference')->nullable(); // Gateway reference number
            $table->string('bank_name')->nullable(); // Bank name for bank transfers
            
            // Payment dates
            $table->datetime('payment_date')->nullable(); // When payment was made
            $table->datetime('processed_at')->nullable(); // When payment was processed
            $table->datetime('failed_at')->nullable(); // When payment failed
            $table->datetime('refunded_at')->nullable(); // When payment was refunded
            
            // Additional information
            $table->text('notes')->nullable(); // Internal notes
            $table->string('receipt_number')->nullable(); // Receipt/invoice number
            $table->json('payment_details')->nullable(); // Additional payment information
            
            $table->timestamps();
            
            // Indexes
            $table->index(['booking_id', 'status']);
            $table->index(['custom_payment_id', 'status']);
            $table->index(['status', 'payment_method']);
            $table->index(['transaction_id']);
            $table->index(['gateway_payment_id']);
            $table->index(['payment_date']);
            $table->index(['created_by']);
            
            // Note: Check constraint for ensuring only one reference type is set
            // Application-level validation will ensure (booking_id IS NOT NULL AND custom_payment_id IS NULL) OR (booking_id IS NULL AND custom_payment_id IS NOT NULL)
            
            // Note: Foreign key constraints removed - validation handled at application level
        });
        DB::statement("ALTER TABLE payments AUTO_INCREMENT = 100000;");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};