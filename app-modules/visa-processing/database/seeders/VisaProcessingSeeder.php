<?php

namespace Modules\VisaProcessing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class VisaProcessingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Skipping visa processing seeding - needs update for new field structure');
        
        // TODO: Update SeedVisaContentCommand to use new country field structure
        // Artisan::call('visa:seed-content', ['--force' => true]);
        
        $this->command->info('Visa processing seeding skipped!');
    }
}