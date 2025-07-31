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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique(); // IATA 2-letter or 3-letter code
            $table->string('icao_code', 4)->unique(); // ICAO 4-letter code
            $table->string('website')->nullable();
            $table->string('headquarters')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->year('founded')->nullable();
            $table->enum('alliance', ['star_alliance', 'oneworld', 'skyteam', 'none'])->default('none');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_low_cost')->default(false);
            $table->json('operating_countries')->nullable(); // Array of country IDs where airline operates
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'position']);
            $table->index(['country_id', 'is_active']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};