<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Closure;
use Illuminate\Container\ContextualBindingBuilder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;

/**
 * A testing application class that helps you to not use mocks.
 */
class TestingContainer implements Container
{
    /**
     * @param array<string, object|Closure(array $makeBindings, class-string $abstract):(object|null)|null> $makeBindings A map of closures that will create.
     *                                                                              Receives make $parameters and
     *                                                                              $abstract string
     * @param Closure(array,string):(object|null)|object|null $makeAlwaysBinding If makeBindings has no entry, it
     *                                                                              will call make on this closure or
     *                                                                              given object. Receives make
     *                                                                              $parameters and $abstract string
     * @param Closure(Closure $call,array $makeBindings,?string $defaultMethod):mixed $call
     */
    public function __construct(
        private array $makeBindings = [],
        private object|null $makeAlwaysBinding = null,
        private readonly ?Closure $call = null,
    ) {
    }

    public function bound($abstract): bool
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

        if (is_object($make) && is_callable($make) === false) {
            return $make;
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
     * @param Closure(array):(object|null)|object|null $make Closure that will receive make parameters and should return an object.
     */
    public function makeReturns(string $abstract, ?object $make): self
    {
        $this->makeBindings[$abstract] = $make;

        return $this;
    }

    /**
     * @param Closure(array,string):(object|null)|object|null $make If makeBindings has no entry, it
     *                                                                              will call make on this closure or
     *                                                                              given object. Receives make
     *                                                                              $parameters and $abstract string
     */
    public function makeAlwaysReturn(object|null $make): self
    {
        $this->makeAlwaysBinding = $make;

        return $this;
    }

    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        if (! $this->call instanceof Closure) {
            return null;
        }

        return call_user_func($this->call, $callback, $parameters, $defaultMethod);
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

    public function bindMethod($method, $callback)
    {

    }
}
