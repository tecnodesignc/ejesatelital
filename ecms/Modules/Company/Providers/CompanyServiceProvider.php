<?php

namespace Modules\Company\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Company\Events\Handlers\RegisterCompanySidebar;

class CompanyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCompanySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('accounts', Arr::dot(trans('company::accounts')));
            $event->load('contacts', Arr::dot(trans('company::contacts')));
            $event->load('accounttypes', Arr::dot(trans('company::accounttypes')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('company', 'permissions');

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
            'Modules\Company\Repositories\AccountRepository',
            function () {
                $repository = new \Modules\Company\Repositories\Eloquent\EloquentAccountRepository(new \Modules\Company\Entities\Account());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Company\Repositories\Cache\CacheAccountDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Company\Repositories\ContactRepository',
            function () {
                $repository = new \Modules\Company\Repositories\Eloquent\EloquentContactRepository(new \Modules\Company\Entities\Contact());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Company\Repositories\Cache\CacheContactDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Company\Repositories\AccountTypeRepository',
            function () {
                $repository = new \Modules\Company\Repositories\Eloquent\EloquentAccountTypeRepository(new \Modules\Company\Entities\AccountType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Company\Repositories\Cache\CacheAccountTypeDecorator($repository);
            }
        );
// add bindings



    }
}
