<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature;

use Illuminate\Foundation\Application;
use LaraStrict\Core\LaraStrictServiceProvider;
use LogicException;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function app(): Application
    {
        if ($this->app === null) {
            throw new LogicException('App not initialized');
        }

        return $this->app;
    }

    protected function getPackageProviders($app)
    {
        return [LaraStrictServiceProvider::class];
    }

    /**
     * Get the available container instance.
     *
     * @template T of object
     *
     * @param class-string<T>   $class
     * @param array<int, mixed> $parameters
     *
     * @return T
     */
    protected function make(string $class, array $parameters = []): object
    {
        $instance = $this->app()
            ->make($class, $parameters);

        assert(assertion: $instance instanceof $class, description: 'Instance is not of type ' . $class);

        return $instance;
    }
}
