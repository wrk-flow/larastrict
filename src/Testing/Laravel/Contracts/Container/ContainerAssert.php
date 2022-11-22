<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Container;

use PHPUnit\Framework\Assert;

class ContainerAssert extends \LaraStrict\Testing\AbstractExpectationCallsMap implements \Illuminate\Contracts\Container\Container
{
    /**
     * @param array<ContainerBoundExpectation> $bound
     * @param array<ContainerAliasExpectation> $alias
     * @param array<ContainerTagExpectation> $tag
     * @param array<ContainerTaggedExpectation> $tagged
     * @param array<ContainerBindExpectation> $bind
     * @param array<ContainerBindIfExpectation> $bindIf
     * @param array<ContainerSingletonExpectation> $singleton
     * @param array<ContainerSingletonIfExpectation> $singletonIf
     * @param array<ContainerScopedExpectation> $scoped
     * @param array<ContainerScopedIfExpectation> $scopedIf
     * @param array<ContainerExtendExpectation> $extend
     * @param array<ContainerInstanceExpectation> $instance
     * @param array<ContainerAddContextualBindingExpectation> $addContextualBinding
     * @param array<ContainerWhenExpectation> $when
     * @param array<ContainerFactoryExpectation> $factory
     * @param array<ContainerFlushExpectation> $flush
     * @param array<ContainerMakeExpectation> $make
     * @param array<ContainerCallExpectation> $call
     * @param array<ContainerResolvedExpectation> $resolved
     * @param array<ContainerBeforeResolvingExpectation> $beforeResolving
     * @param array<ContainerResolvingExpectation> $resolving
     * @param array<ContainerAfterResolvingExpectation> $afterResolving
     * @param array<ContainerGetExpectation> $get
     * @param array<ContainerHasExpectation> $has
     */
    function __construct(
        array $bound = [],
        array $alias = [],
        array $tag = [],
        array $tagged = [],
        array $bind = [],
        array $bindIf = [],
        array $singleton = [],
        array $singletonIf = [],
        array $scoped = [],
        array $scopedIf = [],
        array $extend = [],
        array $instance = [],
        array $addContextualBinding = [],
        array $when = [],
        array $factory = [],
        array $flush = [],
        array $make = [],
        array $call = [],
        array $resolved = [],
        array $beforeResolving = [],
        array $resolving = [],
        array $afterResolving = [],
        array $get = [],
        array $has = [],
    ) {
        $this->setExpectations(ContainerBoundExpectation::class, array_values(array_filter($bound)));
        $this->setExpectations(ContainerAliasExpectation::class, array_values(array_filter($alias)));
        $this->setExpectations(ContainerTagExpectation::class, array_values(array_filter($tag)));
        $this->setExpectations(ContainerTaggedExpectation::class, array_values(array_filter($tagged)));
        $this->setExpectations(ContainerBindExpectation::class, array_values(array_filter($bind)));
        $this->setExpectations(ContainerBindIfExpectation::class, array_values(array_filter($bindIf)));
        $this->setExpectations(ContainerSingletonExpectation::class, array_values(array_filter($singleton)));
        $this->setExpectations(ContainerSingletonIfExpectation::class, array_values(array_filter($singletonIf)));
        $this->setExpectations(ContainerScopedExpectation::class, array_values(array_filter($scoped)));
        $this->setExpectations(ContainerScopedIfExpectation::class, array_values(array_filter($scopedIf)));
        $this->setExpectations(ContainerExtendExpectation::class, array_values(array_filter($extend)));
        $this->setExpectations(ContainerInstanceExpectation::class, array_values(array_filter($instance)));
        $this->setExpectations(ContainerAddContextualBindingExpectation::class, array_values(array_filter($addContextualBinding)));
        $this->setExpectations(ContainerWhenExpectation::class, array_values(array_filter($when)));
        $this->setExpectations(ContainerFactoryExpectation::class, array_values(array_filter($factory)));
        $this->setExpectations(ContainerFlushExpectation::class, array_values(array_filter($flush)));
        $this->setExpectations(ContainerMakeExpectation::class, array_values(array_filter($make)));
        $this->setExpectations(ContainerCallExpectation::class, array_values(array_filter($call)));
        $this->setExpectations(ContainerResolvedExpectation::class, array_values(array_filter($resolved)));
        $this->setExpectations(ContainerBeforeResolvingExpectation::class, array_values(array_filter($beforeResolving)));
        $this->setExpectations(ContainerResolvingExpectation::class, array_values(array_filter($resolving)));
        $this->setExpectations(ContainerAfterResolvingExpectation::class, array_values(array_filter($afterResolving)));
        $this->setExpectations(ContainerGetExpectation::class, array_values(array_filter($get)));
        $this->setExpectations(ContainerHasExpectation::class, array_values(array_filter($has)));
    }

    /**
     * Determine if the given abstract type has been bound.
     *
     * @param  string  $abstract
     * @return bool
     */
    function bound($abstract)
    {
        $expectation = $this->getExpectation(ContainerBoundExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);

        return $expectation->return;
    }

    /**
     * Alias a type to a different name.
     *
     * @param  string  $abstract
     * @param  string  $alias
     * @return void
     *
     * @throws \LogicException
     */
    function alias($abstract, $alias)
    {
        $expectation = $this->getExpectation(ContainerAliasExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->alias, $alias, $message);
    }

    /**
     * Assign a set of tags to a given binding.
     *
     * @param  array|string  $abstracts
     * @param  array|mixed  ...$tags
     * @return void
     */
    function tag($abstracts, $tags)
    {
        $expectation = $this->getExpectation(ContainerTagExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstracts, $abstracts, $message);
        Assert::assertEquals($expectation->tags, $tags, $message);
    }

    /**
     * Resolve all of the bindings for a given tag.
     *
     * @param  string  $tag
     * @return iterable
     */
    function tagged($tag)
    {
        $expectation = $this->getExpectation(ContainerTaggedExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->tag, $tag, $message);

        return $expectation->return;
    }

    /**
     * Register a binding with the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     * @return void
     */
    function bind($abstract, $concrete = null, $shared = false)
    {
        $expectation = $this->getExpectation(ContainerBindExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
        Assert::assertEquals($expectation->shared, $shared, $message);
    }

    /**
     * Register a binding if it hasn't already been registered.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     * @return void
     */
    function bindIf($abstract, $concrete = null, $shared = false)
    {
        $expectation = $this->getExpectation(ContainerBindIfExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
        Assert::assertEquals($expectation->shared, $shared, $message);
    }

    /**
     * Register a shared binding in the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @return void
     */
    function singleton($abstract, $concrete = null)
    {
        $expectation = $this->getExpectation(ContainerSingletonExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
    }

    /**
     * Register a shared binding if it hasn't already been registered.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @return void
     */
    function singletonIf($abstract, $concrete = null)
    {
        $expectation = $this->getExpectation(ContainerSingletonIfExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
    }

    /**
     * Register a scoped binding in the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @return void
     */
    function scoped($abstract, $concrete = null)
    {
        $expectation = $this->getExpectation(ContainerScopedExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
    }

    /**
     * Register a scoped binding if it hasn't already been registered.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @return void
     */
    function scopedIf($abstract, $concrete = null)
    {
        $expectation = $this->getExpectation(ContainerScopedIfExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->concrete, $concrete, $message);
    }

    /**
     * "Extend" an abstract type in the container.
     *
     * @param  string  $abstract
     * @param  \Closure  $closure
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    function extend($abstract, \Closure $closure)
    {
        $expectation = $this->getExpectation(ContainerExtendExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->closure, $closure, $message);
    }

    /**
     * Register an existing instance as shared in the container.
     *
     * @param  string  $abstract
     * @param  mixed  $instance
     * @return mixed
     */
    function instance($abstract, $instance)
    {
        $expectation = $this->getExpectation(ContainerInstanceExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->instance, $instance, $message);

        return $expectation->return;
    }

    /**
     * Add a contextual binding to the container.
     *
     * @param  string  $concrete
     * @param  string  $abstract
     * @param  \Closure|string  $implementation
     * @return void
     */
    function addContextualBinding($concrete, $abstract, $implementation)
    {
        $expectation = $this->getExpectation(ContainerAddContextualBindingExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->concrete, $concrete, $message);
        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->implementation, $implementation, $message);
    }

    /**
     * Define a contextual binding.
     *
     * @param  string|array  $concrete
     * @return \Illuminate\Contracts\Container\ContextualBindingBuilder
     */
    function when($concrete)
    {
        $expectation = $this->getExpectation(ContainerWhenExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->concrete, $concrete, $message);

        return $expectation->return;
    }

    /**
     * Get a closure to resolve the given type from the container.
     *
     * @param  string  $abstract
     * @return \Closure
     */
    function factory($abstract)
    {
        $expectation = $this->getExpectation(ContainerFactoryExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);

        return $expectation->return;
    }

    /**
     * Flush the container of all bindings and resolved instances.
     *
     * @return void
     */
    function flush()
    {
        $expectation = $this->getExpectation(ContainerFlushExpectation::class);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function make($abstract, array $parameters = [])
    {
        $expectation = $this->getExpectation(ContainerMakeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->parameters, $parameters, $message);

        return $expectation->return;
    }

    /**
     * Call the given Closure / class@method and inject its dependencies.
     *
     * @param  callable|string  $callback
     * @param  array  $parameters
     * @param  string|null  $defaultMethod
     * @return mixed
     */
    function call($callback, array $parameters = [], $defaultMethod = null)
    {
        $expectation = $this->getExpectation(ContainerCallExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->callback, $callback, $message);
        Assert::assertEquals($expectation->parameters, $parameters, $message);
        Assert::assertEquals($expectation->defaultMethod, $defaultMethod, $message);

        return $expectation->return;
    }

    /**
     * Determine if the given abstract type has been resolved.
     *
     * @param  string  $abstract
     * @return bool
     */
    function resolved($abstract)
    {
        $expectation = $this->getExpectation(ContainerResolvedExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);

        return $expectation->return;
    }

    /**
     * Register a new before resolving callback.
     *
     * @param  \Closure|string  $abstract
     * @param  \Closure|null  $callback
     * @return void
     */
    function beforeResolving($abstract, \Closure $callback = null)
    {
        $expectation = $this->getExpectation(ContainerBeforeResolvingExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);
    }

    /**
     * Register a new resolving callback.
     *
     * @param  \Closure|string  $abstract
     * @param  \Closure|null  $callback
     * @return void
     */
    function resolving($abstract, \Closure $callback = null)
    {
        $expectation = $this->getExpectation(ContainerResolvingExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);
    }

    /**
     * Register a new after resolving callback.
     *
     * @param  \Closure|string  $abstract
     * @param  \Closure|null  $callback
     * @return void
     */
    function afterResolving($abstract, \Closure $callback = null)
    {
        $expectation = $this->getExpectation(ContainerAfterResolvingExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abstract, $abstract, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    function get(string $id)
    {
        $expectation = $this->getExpectation(ContainerGetExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->id, $id, $message);

        return $expectation->return;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    function has(string $id): bool
    {
        $expectation = $this->getExpectation(ContainerHasExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->id, $id, $message);

        return $expectation->return;
    }
}
