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
        Schema::create('custom_payments', function (Blueprint $table) {
            $table->id();
            
            // Customer details from frontend form
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile', 20);
            $table->decimal('amount', 10, 2);
            
            // Additional form fields
            $table->string('purpose')->nullable(); // Purpose of payment
            $table->text('description')->nullable(); // Payment description
            $table->string('reference_number')->nullable(); // Customer reference
            $table->string('payment_method')->nullable(); // 'sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer', 'cash', 'other'
            
            // Form submission details
            $table->string('status')->default('submitted'); // 'submitted', 'processing', 'completed', 'cancelled'
            $table->json('form_data')->nullable(); // Complete form submission data
            $table->string('ip_address')->nullable(); // Submitter's IP
            $table->string('user_agent')->nullable(); // Submitter's browser info
            
            // Processing information
            $table->datetime('submitted_at'); // When form was submitted
            $table->datetime('processed_at')->nullable(); // When payment processing started
            $table->datetime('completed_at')->nullable(); // When payment was completed
            
            // Admin notes
            $table->text('admin_notes')->nullable(); // Internal admin notes
            $table->foreignId('processed_by')->nullable(); // Admin who processed
            
            // Note: Foreign key constraints removed - validation handled at application level
            
            $table->timestamps();
            
            // Indexes
            $table->index(['email', 'status']);
            $table->index(['mobile', 'status']);
            $table->index(['status', 'submitted_at']);
            $table->index(['submitted_at']);
            $table->index(['amount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_payments');
    }
};