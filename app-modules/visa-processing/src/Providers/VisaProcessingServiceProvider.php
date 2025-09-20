<?php

namespace Modules\VisaProcessing\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\VisaProcessing\Console\Commands\SeedVisaContentCommand;

class VisaProcessingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedVisaContentCommand::class,
            ]);
        }
    }
    
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/visa-processing-routes.php');
        
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'visa-processing');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
