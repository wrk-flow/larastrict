<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LaraStrict\Cache\CacheServiceProvider;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Console\Services\ScheduleServiceService;
use LaraStrict\Context\ContextServiceProvider;

class LaraStrictServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->register(ContextServiceProvider::class);
        $this->app->register(CacheServiceProvider::class);

        // Add ability to "switch" the implementation.
        $this->app->singleton(ScheduleServiceContract::class, ScheduleServiceContract::class);
        $this->app->alias(ScheduleServiceService::class, ScheduleServiceContract::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // TODO config
        $this->setupFactoryResolving();

        // TODO config
        // Model::preventLazyLoading(true);
    }

    /**
     * We want to place factories in same folder as the model.
     */
    protected function setupFactoryResolving(): void
    {
        Factory::guessFactoryNamesUsing(function (string $class) {
            /** @var class-string<Factory<Model>> $factoryClass */
            $factoryClass = $class . 'Factory';

            return $factoryClass;
        });

        Factory::guessModelNamesUsing(function (Factory $factory) {
            /** @var class-string<Model> $class */
            $class = Str::replaceLast('Factory', '', $factory::class);

            return $class;
        });
    }
}
