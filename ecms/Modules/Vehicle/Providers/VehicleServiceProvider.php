<?php

namespace Modules\Vehicle\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Vehicle\Events\Handlers\RegisterVehicleSidebar;

class VehicleServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterVehicleSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('vehicles', Arr::dot(trans('vehicle::vehicles')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('vehicle', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Vehicle\Repositories\VehicleRepository',
            function () {
                $repository = new \Modules\Vehicle\Repositories\Eloquent\EloquentVehicleRepository(new \Modules\Vehicle\Entities\Vehicle());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Vehicle\Repositories\Cache\CacheVehicleDecorator($repository);
            }
        );
// add bindings

    }
}
