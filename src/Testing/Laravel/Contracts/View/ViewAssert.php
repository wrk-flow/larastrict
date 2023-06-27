<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\View;

use Illuminate\Contracts\View\View;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class ViewAssert extends AbstractExpectationCallsMap implements View
{
    /**
     * @param array<ViewNameExpectation|null> $name
     * @param array<ViewWithExpectation|null> $with
     * @param array<ViewGetDataExpectation|null> $getData
     * @param array<ViewRenderExpectation|null> $render
     */
    public function __construct(array $name = [], array $with = [], array $getData = [], array $render = [])
    {
        parent::__construct();
        $this->setExpectations(ViewNameExpectation::class, $name);
        $this->setExpectations(ViewWithExpectation::class, $with);
        $this->setExpectations(ViewGetDataExpectation::class, $getData);
        $this->setExpectations(ViewRenderExpectation::class, $render);
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
