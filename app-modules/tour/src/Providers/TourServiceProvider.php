<?php

namespace Modules\Tour\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourDate;
use Modules\Tour\Models\TourItinerary;

class TourServiceProvider extends ServiceProvider
{
    /**
     * The module namespace.
     */
    protected string $namespace = 'Modules\Tour';

    /**
     * The module path.
     */
    protected string $modulePath = __DIR__ . '/../../';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerMorphMap();
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/tour');
        $sourcePath = $this->modulePath . 'resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'tour-views');

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), 'tour');
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom($this->modulePath . 'routes/tour-routes.php');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom($this->modulePath . 'database/migrations');
    }

    /**
     * Register morph map for polymorphic relationships.
     */
    protected function registerMorphMap(): void
    {
        Relation::morphMap([
            'tour' => Tour::class,
            'tour_date' => TourDate::class,
            'tour_itinerary' => TourItinerary::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    /**
     * Get publishable view paths.
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        
        foreach ($this->app['config']['view.paths'] as $path) {
            if (is_dir($path . '/modules/tour')) {
                $paths[] = $path . '/modules/tour';
            }
        }
        
        return $paths;
    }
}
