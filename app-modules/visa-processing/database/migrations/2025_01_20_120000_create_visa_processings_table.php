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
        Schema::create('visa_processings', function (Blueprint $table) {
            $table->id();
            $table->string('english_title');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('slug')->unique();
            $table->json('title'); // Translatable field
            $table->json('content')->nullable(); // Translatable field
            
            // Visa specific fields
            $table->string('country'); // Country translation key (e.g., 'australia', 'south_korea')
            $table->string('visa_type')->default('tourist'); // tourist, business, student, etc.
            $table->decimal('visa_fees', 10, 2); // Visa fees in BDT
            $table->decimal('processing_fee', 10, 2)->default(0); // Additional processing fee
            $table->integer('processing_days')->nullable(); // Estimated processing days
            $table->json('required_documents')->nullable(); // List of required documents
            
            // SEO fields (translatable)
            $table->json('meta_title')->nullable(); // SEO meta title (translatable)
            $table->json('meta_description')->nullable(); // SEO meta description (translatable)
            $table->json('keywords')->nullable(); // SEO keywords (translatable)
            
            // Status and publishing
            $table->string('status')->default('draft'); // enum: draft,published
            $table->timestamp('published_at')->nullable();
            $table->integer('position')->default(0);
            
            // Additional visa processing fields
            $table->boolean('is_featured')->default(false);
            $table->integer('estimated_processing_time')->nullable(); // In days
            $table->json('embassy_info')->nullable(); // Embassy contact details
            $table->string('difficulty_level')->default('medium'); // easy, medium, hard
            
            $table->timestamps();
            
            $table->index(['status', 'published_at']);
            $table->index('position');
            $table->index(['country', 'visa_type']);
            $table->index('is_featured');
            $table->index('visa_fees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_processings');
    }
};