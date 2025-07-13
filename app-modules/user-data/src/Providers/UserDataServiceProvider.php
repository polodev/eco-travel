<?php

namespace Modules\UserData\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class UserDataServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load migrations
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
		
		// Load views
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'user-data');
		
		// Register Volt components for this module
		Volt::mount([
			__DIR__ . '/../../resources/views/livewire'
		]);
	}
}
