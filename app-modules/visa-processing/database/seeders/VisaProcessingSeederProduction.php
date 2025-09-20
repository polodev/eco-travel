<?php

namespace Modules\VisaProcessing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class VisaProcessingSeederProduction extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        $this->command->info('Seeding visa processing content for production...');
        
        // Run the visa content seeder command with force flag for production
        Artisan::call('visa:seed-content', ['--force' => true]);
        
        $this->command->info('Production visa processing content seeded successfully!');
    }
}