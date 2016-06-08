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
        // Views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'fleetany-web-geofence');

        // Routes
        include __DIR__.'/../../routes.php';
        
        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/../../translations', 'fleetany-web-geofence');
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
