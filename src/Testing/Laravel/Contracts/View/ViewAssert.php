<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Illuminate\Contracts\View\View;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class ViewAssert extends AbstractExpectationCallsMap implements View
{
    /**
     * @param array<ViewNameExpectation> $name
     * @param array<ViewWithExpectation> $with
     * @param array<ViewGetDataExpectation> $getData
     * @param array<ViewRenderExpectation> $render
     */
    public function __construct(array $name = [], array $with = [], array $getData = [], array $render = [])
    {
        $this->setExpectations(ViewNameExpectation::class, array_values(array_filter($name)));
        $this->setExpectations(ViewWithExpectation::class, array_values(array_filter($with)));
        $this->setExpectations(ViewGetDataExpectation::class, array_values(array_filter($getData)));
        $this->setExpectations(ViewRenderExpectation::class, array_values(array_filter($render)));
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name()
    {
        $expectation = $this->getExpectation(ViewNameExpectation::class);

        return $expectation->return;
    }

    /**
     * Add a piece of data to the view.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $expectation = $this->getExpectation(ViewWithExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->key, $key, $message);
        Assert::assertEquals($expectation->value, $value, $message);

        return $this;
    }

    /**
     * Get the array of view data.
     *
     * @return array
     */
    public function getData()
    {
        $expectation = $this->getExpectation(ViewGetDataExpectation::class);

        return $expectation->return;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $expectation = $this->getExpectation(ViewRenderExpectation::class);

        return $expectation->return;
    }
}
