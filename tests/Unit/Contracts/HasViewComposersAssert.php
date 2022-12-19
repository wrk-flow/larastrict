<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Contracts;

use Illuminate\Contracts\View\Factory;
use LaraStrict\Contracts\HasViewComposers;
use LaraStrict\Testing\AbstractExpectationCallMap;
use PHPUnit\Framework\Assert;

/**
 * @extends AbstractExpectationCallMap<HasViewComposersExpectation>
 */
class HasViewComposersAssert extends AbstractExpectationCallMap implements HasViewComposers
{
    public function bootViewComposers(string $serviceName, Factory $viewFactory): void
    {
        $expectation = $this->getExpectation();
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->serviceName, $serviceName, $message);
        Assert::assertEquals($expectation->viewFactory, $viewFactory, $message);
    }
}
