<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class TestListenerCallsContractAssert extends AbstractExpectationCallsMap implements TestListenerCallsContract
{
    /**
     * @param array<TestListenerCallsContractHandleExpectation> $handle
     * @param array<TestListenerCallsContractTestExpectation> $test
     */
    public function __construct(array $handle = [], array $test = [])
    {
        $this->setExpectations(TestListenerCallsContractHandleExpectation::class, array_values(array_filter($handle)));
        $this->setExpectations(TestListenerCallsContractTestExpectation::class, array_values(array_filter($test)));
    }

    public function handle(TestEvent $event): void
    {
        $expectation = $this->getExpectation(TestListenerCallsContractHandleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $event, $expectation);
        }
    }

    public function test(): void
    {
        $expectation = $this->getExpectation(TestListenerCallsContractTestExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }
    }
}
