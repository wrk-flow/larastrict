<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class FactoryAssert extends AbstractExpectationCallsMap implements Factory
{
    /**
     * @param array<FactoryExistsExpectation> $exists
     * @param array<FactoryFileExpectation> $file
     * @param array<FactoryMakeExpectation> $make
     * @param array<FactoryShareExpectation> $share
     * @param array<FactoryComposerExpectation> $composer
     * @param array<FactoryCreatorExpectation> $creator
     * @param array<FactoryAddNamespaceExpectation> $addNamespace
     * @param array<FactoryReplaceNamespaceExpectation> $replaceNamespace
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
        $this->setExpectations(FactoryExistsExpectation::class, array_values(array_filter($exists)));
        $this->setExpectations(FactoryFileExpectation::class, array_values(array_filter($file)));
        $this->setExpectations(FactoryMakeExpectation::class, array_values(array_filter($make)));
        $this->setExpectations(FactoryShareExpectation::class, array_values(array_filter($share)));
        $this->setExpectations(FactoryComposerExpectation::class, array_values(array_filter($composer)));
        $this->setExpectations(FactoryCreatorExpectation::class, array_values(array_filter($creator)));
        $this->setExpectations(FactoryAddNamespaceExpectation::class, array_values(array_filter($addNamespace)));
        $this->setExpectations(
            FactoryReplaceNamespaceExpectation::class,
            array_values(array_filter($replaceNamespace))
        );
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
