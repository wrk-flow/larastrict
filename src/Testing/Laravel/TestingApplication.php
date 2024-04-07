<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * A testing application class that helps you to not use mocks.
 */
class TestingApplication extends TestingContainer implements Application
{
    /**
     * @param array<string, object|Closure(array):(object|null)> $makeBindings      A map of closures that will create.
     *                                                                       Receives make $parameters and $abstract
     *                                                                       string
     * @param Closure(array,string):(object|null)|null    $makeAlwaysBinding If makeBindings has no entry, it will call
     *                                                                       make on this closure. Receives make
     *                                                                       $parameters and $abstract string
     */
    public function __construct(
        public string $currentEnvironment = 'testing',
        public bool $runningInConsole = false,
        public bool $isDownForMaintenance = false,
        public MaintenanceMode $maintenanceMode = new MaintenanceMode(),
        array $makeBindings = [],
        Closure|null $makeAlwaysBinding = null,
        public string $basePath = 'base',
    ) {
        parent::__construct($makeBindings, $makeAlwaysBinding);
    }

    public function version()
    {
        return 'test';
    }

    public function basePath($path = '')
    {
        return $this->basePath . $this->addPath($path);
    }

    public function bootstrapPath($path = '')
    {
        return 'bootstrap' . $this->addPath($path);
    }

    public function configPath($path = '')
    {
        return 'config' . $this->addPath($path);
    }

    public function databasePath($path = '')
    {
        return 'database' . $this->addPath($path);
    }

    public function resourcePath($path = '')
    {
        return 'resource' . $this->addPath($path);
    }

    public function storagePath($path = '')
    {
        return 'storage' . $this->addPath($path);
    }

    public function environment(...$environments)
    {
        return in_array($this->currentEnvironment, $environments, true);
    }

    public function runningInConsole()
    {
        return $this->runningInConsole;
    }

    public function runningUnitTests()
    {
        return true;
    }

    public function maintenanceMode()
    {
        return $this->maintenanceMode;
    }

    public function isDownForMaintenance()
    {
        return $this->isDownForMaintenance;
    }

    public function registerConfiguredProviders()
    {
    }

    public function register($provider, $force = false)
    {
        return new TestingServiceProvider($this, $provider);
    }

    public function registerDeferredProvider($provider, $service = null)
    {
    }

    public function resolveProvider($provider)
    {
        return new TestingServiceProvider($this, $provider);
    }

    public function boot()
    {
    }

    public function booting($callback)
    {
    }

    public function booted($callback)
    {
    }

    public function bootstrapWith(array $bootstrappers)
    {
    }

    public function getLocale()
    {
        return 'en';
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getProviders($provider)
    {
        return [];
    }

    public function hasBeenBootstrapped()
    {
        return false;
    }

    public function loadDeferredProviders()
    {
    }

    public function setLocale($locale)
    {
    }

    public function shouldSkipMiddleware()
    {
        return false;
    }

    public function terminating($callback)
    {
        return $this;
    }

    public function terminate()
    {
    }

    public function langPath($path = '')
    {
        return 'lang/' . $this->addPath($path);
    }

    public function publicPath($path = '')
    {
        return 'public/' . $this->addPath($path);
    }

    public function hasDebugModeEnabled()
    {
        return false;
    }

    protected function addPath(string $path): string
    {
        return $path !== '' ? DIRECTORY_SEPARATOR . $path : '';
    }
}
