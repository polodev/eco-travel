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
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visa_processing_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->string('application_number')->unique();
            
            // Applicant Information
            $table->string('applicant_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('passport_number')->nullable();
            $table->date('travel_date')->nullable();
            $table->text('customer_notes')->nullable();
            
            // Application Status and Management
            $table->enum('application_status', [
                'pending', 
                'under_review', 
                'documents_requested',
                'approved', 
                'rejected', 
                'completed'
            ])->default('pending');
            
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('submission_date')->useCurrent();
            $table->timestamp('completion_date')->nullable();
            
            // Tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['application_status', 'submission_date']);
            $table->index(['visa_processing_id', 'application_status']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_applications');
    }
};