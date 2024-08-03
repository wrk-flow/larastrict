<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\CreateAppServiceProviderActionContract;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Providers\Actions\CreateAppServiceProviderAction;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LogicException;

/**
 * From Laravel 10+ the EventServiceProvider cant be used anymore, it was designed to be used only once
 * within app/Providers/EventServiceProvider.php. We are using $listen shortcut so let's use similar implementation.
 */
abstract class AbstractBaseServiceProvider extends ServiceProvider
{
    protected AppServiceProviderEntity|null $appServiceProvider = null;

    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected array $listen = [];

    public function register(): void
    {
        parent::register();

        $runPipes = $this->app->make(RunAppServiceProviderPipesActionContract::class);
        assert($runPipes instanceof RunAppServiceProviderPipesActionContract);

        $runPipes->execute($this->getAppServiceProvider(), $this->registerPipes());

        $this->booting(function () {
            $events = $this->app->make(Dispatcher::class);
            assert($events instanceof Dispatcher);

            // Taken from vendor/laravel/framework/src/Illuminate/Foundation/Support/Providers/EventServiceProvider.php
            foreach ($this->listen as $event => $listeners) {
                foreach (array_unique($listeners, SORT_REGULAR) as $listener) {
                    $events->listen($event, $listener);
                }
            }
        });
    }

    public function boot(): void
    {
        $runPipes = $this->app->make(RunAppServiceProviderPipesActionContract::class);
        assert($runPipes instanceof RunAppServiceProviderPipesActionContract);

        $runPipes->execute($this->getAppServiceProvider(), $this->bootPipes());
    }

    public function getAppServiceProvider(): AppServiceProviderEntity
    {
        if (! $this->appServiceProvider instanceof AppServiceProviderEntity) {
            $action = $this->app->make($this->getCreateAppServiceProviderActionClass());
            assert($action instanceof CreateAppServiceProviderActionContract);

            $this->appServiceProvider = $action->execute($this->app, $this);
        }

        return $this->appServiceProvider;
    }

    /**
     * @param array<string>|string $path
     */
    public function laraLoadViewsFrom(array|string $path, string $namespace): void
    {
        $this->loadViewsFrom($path, $namespace);
    }

    public function laraLoadTranslationsFrom(string $path, string $namespace): void
    {
        $this->loadTranslationsFrom($path, $namespace);
    }

    public function laraLoadProviderConfigFrom(string $path, string $namespace): void
    {
        $serviceFileName = $namespace . '.php';
        $configPath = $path . '/Config/' . $serviceFileName;
        $realPath = realpath($configPath);

        if ($realPath === false) {
            throw new LogicException('Failed to load config at ' . $configPath);
        }

        $this->mergeConfigFrom($realPath, $namespace);
    }

    /**
     * @return array<class-string<AppServiceProviderPipeContract>>
     */
    abstract protected function registerPipes(): array;

    /**
     * @return array<class-string<AppServiceProviderPipeContract>>
     */
    abstract protected function bootPipes(): array;

    /**
     * @return class-string<CreateAppServiceProviderActionContract>
     */
    protected function getCreateAppServiceProviderActionClass(): string
    {
        return CreateAppServiceProviderAction::class;
    }
}
