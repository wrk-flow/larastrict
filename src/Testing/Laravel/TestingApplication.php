<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Closure;
use Illuminate\Container\ContextualBindingBuilder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;

/**
 * A testing application class that helps you to not use mocks.
 */
class TestingApplication implements Application
{
    /**
     * @param array<string, Closure(array):(object|null)> $makeBindings      A map of closures that will create.
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
        private array $makeBindings = [],
        private Closure|null $makeAlwaysBinding = null,
    ) {
    }

    public function version()
    {
        return 'test';
    }

    public function basePath($path = '')
    {
        return 'base/' . $path;
    }

    public function bootstrapPath($path = '')
    {
        return 'bootstrap/' . $path;
    }

    public function configPath($path = '')
    {
        return 'config/' . $path;
    }

    public function databasePath($path = '')
    {
        return 'database/' . $path;
    }

    public function resourcePath($path = '')
    {
        return 'resource/' . $path;
    }

    public function storagePath($path = '')
    {
        return 'storage/' . $path;
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

    public function bound($abstract)
    {
        return false;
    }

    public function alias($abstract, $alias)
    {
    }

    public function tag($abstracts, $tags)
    {
    }

    public function tagged($tag)
    {
        return [];
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
    }

    public function bindIf($abstract, $concrete = null, $shared = false)
    {
    }

    public function singleton($abstract, $concrete = null)
    {
    }

    public function singletonIf($abstract, $concrete = null)
    {
    }

    public function scoped($abstract, $concrete = null)
    {
    }

    public function scopedIf($abstract, $concrete = null)
    {
    }

    public function extend($abstract, Closure $closure)
    {
    }

    public function instance($abstract, $instance)
    {
    }

    public function addContextualBinding($concrete, $abstract, $implementation)
    {
    }

    public function when($concrete)
    {
        return new ContextualBindingBuilder($this, $concrete);
    }

    public function factory($abstract)
    {
        return static function () {
        };
    }

    public function flush()
    {
    }

    public function make($abstract, array $parameters = [])
    {
        $make = $this->makeBindings[$abstract] ?? null;

        if ($make === null && $this->makeAlwaysBinding !== null) {
            $make = $this->makeAlwaysBinding;
        }

        if ($make === null) {
            throw new BindingResolutionException('Binding not set ' . $abstract);
        }

        $result = $make($parameters, $abstract);

        if ($result === null) {
            throw new BindingResolutionException('Failed to resolve ' . $abstract);
        }

        return $result;
    }

    /**
     * @param Closure(array):?object $make Closure that will receive make parameters and should return an object.
     */
    public function makeReturns(string $abstract, Closure $make): void
    {
        $this->makeBindings[$abstract] = $make;
    }

    public function makeAlwaysReturn(Closure $make): void
    {
        $this->makeAlwaysBinding = $make;
    }

    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
    }

    public function resolved($abstract)
    {
        return false;
    }

    public function beforeResolving($abstract, Closure $callback = null)
    {
    }

    public function resolving($abstract, Closure $callback = null)
    {
    }

    public function afterResolving($abstract, Closure $callback = null)
    {
    }

    public function get(string $id)
    {
        return null;
    }

    public function has(string $id): bool
    {
        return false;
    }
}
