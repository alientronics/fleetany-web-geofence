<?php

namespace Alientronics\FleetanyWebGeofence;

use Illuminate\Support\ServiceProvider;

/**
 * Class FleetanyWebGeofenceServiceProvider
 * @package Alientronics\FleetanyWebGeofence
 */
class FleetanyWebGeofenceServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot()
    {
		$this->publishViews();
        $this->publishTranslations();
    }
	
	/**
     * Publish the views files to the application views directory
     */
    public function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../../views/' => base_path('/resources/views'),
        ], 'translations');
    }
	
	/**
     * Publish the translations files to the application translations directory
     */
    public function publishTranslations()
    {
        $this->publishes([
            __DIR__ . '/../../translations/' => base_path('/resources/lang'),
        ], 'translations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
