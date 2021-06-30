<?php

namespace Modules\Location\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Location\Events\Handlers\RegisterLocationSidebar;
use Illuminate\Support\Arr;

class LocationServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterLocationSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('countries', Arr::dot(trans('location::countries')));
            $event->load('provinces', Arr::dot(trans('location::provinces')));
            $event->load('cities', Arr::dot(trans('location::cities')));
            $event->load('polygons', Arr::dot(trans('location::polygons')));
            $event->load('neighborhoods', Arr::dot(trans('location::neighborhoods')));
            // append translations





        });
    }

    public function boot()
    {
        $this->publishConfig('location', 'permissions');

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
            'Modules\Location\Repositories\CountryRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentCountryRepository(new \Modules\Location\Entities\Country());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheCountryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Location\Repositories\ProvinceRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentProvinceRepository(new \Modules\Location\Entities\Province());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheProvinceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Location\Repositories\CityRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentCityRepository(new \Modules\Location\Entities\City());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheCityDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Location\Repositories\PolygonRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentPolygonRepository(new \Modules\Location\Entities\Polygon());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CachePolygonDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Location\Repositories\NeighborhoodRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentNeighborhoodRepository(new \Modules\Location\Entities\Neighborhood());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheNeighborhoodDecorator($repository);
            }
        );
// add bindings





    }
}
