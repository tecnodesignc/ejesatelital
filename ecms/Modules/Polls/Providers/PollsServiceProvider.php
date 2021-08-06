<?php

namespace Modules\Polls\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Polls\Events\Handlers\RegisterPollsSidebar;
use Illuminate\Support\Arr;

class PollsServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPollsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('questiontypes', Arr::dot(trans('polls::questiontypes')));
            $event->load('questions', Arr::dot(trans('polls::questions')));
            $event->load('answers', Arr::dot(trans('polls::answers')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('polls', 'permissions');

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
            'Modules\Polls\Repositories\QuestionTypeRepository',
            function () {
                $repository = new \Modules\Polls\Repositories\Eloquent\EloquentQuestionTypeRepository(new \Modules\Polls\Entities\QuestionType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Polls\Repositories\Cache\CacheQuestionTypeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Polls\Repositories\QuestionRepository',
            function () {
                $repository = new \Modules\Polls\Repositories\Eloquent\EloquentQuestionRepository(new \Modules\Polls\Entities\Question());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Polls\Repositories\Cache\CacheQuestionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Polls\Repositories\AnswerRepository',
            function () {
                $repository = new \Modules\Polls\Repositories\Eloquent\EloquentAnswerRepository(new \Modules\Polls\Entities\Answer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Polls\Repositories\Cache\CacheAnswerDecorator($repository);
            }
        );
// add bindings



    }
}
