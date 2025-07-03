<?php

namespace Modules\UserData\Providers;

use Illuminate\Support\ServiceProvider;

class UserDataServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		// Load migrations
		$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
	}
}
