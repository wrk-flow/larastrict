<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Contracts;

use Illuminate\Contracts\View\Factory;
use LaraStrict\Contracts\HasViewComposers;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class HasViewComposersAssert extends AbstractExpectationCallsMap implements HasViewComposers
{
    /**
     * @param array<HasViewComposersExpectation|null> $expectations
     */
    public function __construct(array $expectations = [])
    {
        parent::__construct();

        $this->setExpectations(HasViewComposersExpectation::class, $expectations);
    }

    public function bootViewComposers(string $serviceName, Factory $viewFactory): void
    {
        $expectation = $this->getExpectation(HasViewComposersExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->serviceName, $serviceName, $message);
        Assert::assertEquals($expectation->viewFactory, $viewFactory, $message);
    }
}
