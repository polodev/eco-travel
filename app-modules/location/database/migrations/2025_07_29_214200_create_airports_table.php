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
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreignId('city_id')->nullable();
            $table->string('name');
            $table->string('iata_code', 3)->unique(); // 3-letter IATA code
            $table->string('icao_code', 4)->unique(); // 4-letter ICAO code
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->string('timezone')->nullable();
            $table->enum('type', ['international', 'domestic', 'regional'])->default('domestic');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hub')->default(false);
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->index(['country_id', 'city_id']);
            $table->index(['is_active', 'type']);
            $table->index('iata_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};