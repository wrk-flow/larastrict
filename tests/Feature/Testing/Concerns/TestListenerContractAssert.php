<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class TestListenerContractAssert extends AbstractExpectationCallsMap implements TestListenerContract
{
    /**
     * @param array<TestListenerContractExpectation|null> $expectations
     */
    public function __construct(array $expectations = [])
    {
        parent::__construct();

        $this->setExpectations(TestListenerContractExpectation::class, $expectations);
    }

    public function handle(TestEvent $event): void
    {
        $expectation = $this->getExpectation(TestListenerContractExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $event, $expectation);
        }
    }
}
