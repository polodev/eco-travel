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
        Schema::table('custom_payments', function (Blueprint $table) {
            // Add composite index for rate limiting queries (ip_address + created_at)
            $table->index(['ip_address', 'created_at']);
            // Add standalone ip_address index for general IP tracking
            $table->index(['ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_payments', function (Blueprint $table) {
            // Drop the composite index
            $table->dropIndex(['ip_address', 'created_at']);
            // Drop the standalone ip_address index
            $table->dropIndex(['ip_address']);
        });
    }
};
