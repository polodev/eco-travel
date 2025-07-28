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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('english_title');
            $table->foreignId('user_id')->nullable();
            $table->string('slug')->unique();
            $table->json('title'); // Translatable field
            $table->json('content')->nullable(); // Translatable field
            $table->json('excerpt')->nullable(); // Translatable field
            $table->string('status')->default('draft'); // enum: draft,published,scheduled
            $table->string('featured_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'published_at']);
            $table->index('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};