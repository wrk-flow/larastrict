<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\CreateAppServiceProviderActionContract;
use LaraStrict\Contracts\RunAppServiceProviderPipesActionContract;
use LaraStrict\Providers\Actions\CreateAppServiceProviderAction;
use LaraStrict\Providers\Entities\AppServiceProviderEntity;
use LogicException;

abstract class AbstractBaseServiceProvider extends EventServiceProvider
{
    protected AppServiceProviderEntity|null $appServiceProvider = null;

    public function register(): void
    {
        parent::register();

        /** @var RunAppServiceProviderPipesActionContract $runPipes */
        $runPipes = $this->app->make(RunAppServiceProviderPipesActionContract::class);

        $runPipes->execute($this->getAppServiceProvider(), $this->registerPipes());
    }

    public function boot(): void
    {
        parent::boot();

        /** @var RunAppServiceProviderPipesActionContract $runPipes */
        $runPipes = $this->app->make(RunAppServiceProviderPipesActionContract::class);

        $runPipes->execute($this->getAppServiceProvider(), $this->bootPipes());
    }

    public function getAppServiceProvider(): AppServiceProviderEntity
    {
        if ($this->appServiceProvider === null) {
            /** @var CreateAppServiceProviderAction $action */
            $action = $this->app->make($this->getCreateAppServiceProviderActionClass());

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
