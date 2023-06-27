<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class FactoryAssert extends AbstractExpectationCallsMap implements Factory
{
    /**
     * @param array<FactoryExistsExpectation|null> $exists
     * @param array<FactoryFileExpectation|null> $file
     * @param array<FactoryMakeExpectation|null> $make
     * @param array<FactoryShareExpectation|null> $share
     * @param array<FactoryComposerExpectation|null> $composer
     * @param array<FactoryCreatorExpectation|null> $creator
     * @param array<FactoryAddNamespaceExpectation|null> $addNamespace
     * @param array<FactoryReplaceNamespaceExpectation|null> $replaceNamespace
     */
    public function __construct(
        array $exists = [],
        array $file = [],
        array $make = [],
        array $share = [],
        array $composer = [],
        array $creator = [],
        array $addNamespace = [],
        array $replaceNamespace = [],
    ) {
        parent::__construct();
        $this->setExpectations(FactoryExistsExpectation::class, $exists);
        $this->setExpectations(FactoryFileExpectation::class, $file);
        $this->setExpectations(FactoryMakeExpectation::class, $make);
        $this->setExpectations(FactoryShareExpectation::class, $share);
        $this->setExpectations(FactoryComposerExpectation::class, $composer);
        $this->setExpectations(FactoryCreatorExpectation::class, $creator);
        $this->setExpectations(FactoryAddNamespaceExpectation::class, $addNamespace);
        $this->setExpectations(FactoryReplaceNamespaceExpectation::class, $replaceNamespace);
    }

    /**
     * Determine if a given view exists.
     *
     * @param  string  $view
     * @return bool
     */
    public function exists($view)
    {
        $expectation = $this->getExpectation(FactoryExistsExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->view, $view, $message);

        return $expectation->return;
    }

    /**
     * Get the evaluated view contents for the given path.
     *
     * @param  string  $path
     * @param Arrayable<string, mixed>|array $data
     * @param  array  $mergeData
     * @return View
     */
    public function file($path, $data = [], $mergeData = [])
    {
        $expectation = $this->getExpectation(FactoryFileExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->path, $path, $message);
        Assert::assertEquals($expectation->data, $data, $message);
        Assert::assertEquals($expectation->mergeData, $mergeData, $message);

        return $expectation->return;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param Arrayable<string, mixed>|array $data
     * @param  array  $mergeData
     * @return View
     */
    public function make($view, $data = [], $mergeData = [])
    {
        $expectation = $this->getExpectation(FactoryMakeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->view, $view, $message);
        Assert::assertEquals($expectation->data, $data, $message);
        Assert::assertEquals($expectation->mergeData, $mergeData, $message);

        return $expectation->return;
    }

    /**
     * Add a piece of shared data to the environment.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function share($key, $value = null)
    {
        $expectation = $this->getExpectation(FactoryShareExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        return $expectation->return;
    }

    /**
     * Register a view composer event.
     *
     * @param  array|string  $views
     * @param Closure|string $callback
     * @return array
     */
    public function composer($views, $callback)
    {
        $expectation = $this->getExpectation(FactoryComposerExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->views, $views, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);

        return $expectation->return;
    }

    /**
     * Register a view creator event.
     *
     * @param  array|string  $views
     * @param Closure|string $callback
     * @return array
     */
    public function creator($views, $callback)
    {
        $expectation = $this->getExpectation(FactoryCreatorExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->views, $views, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);

        return $expectation->return;
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return $this
     */
    public function addNamespace($namespace, $hints)
    {
        $expectation = $this->getExpectation(FactoryAddNamespaceExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->namespace, $namespace, $message);
        Assert::assertEquals($expectation->hints, $hints, $message);

        return $this;
    }

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @return $this
     */
    public function replaceNamespace($namespace, $hints)
    {
        $expectation = $this->getExpectation(FactoryReplaceNamespaceExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->namespace, $namespace, $message);
        Assert::assertEquals($expectation->hints, $hints, $message);

        return $this;
    }
}
