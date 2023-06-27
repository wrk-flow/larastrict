<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class TestListenerCallsContractAssert extends AbstractExpectationCallsMap implements TestListenerCallsContract
{
    /**
     * @param array<TestListenerCallsContractHandleExpectation|null> $handle
     * @param array<TestListenerCallsContractTestExpectation|null> $test
     */
    public function __construct(array $handle = [], array $test = [])
    {
        parent::__construct();

        $this->setExpectations(TestListenerCallsContractHandleExpectation::class, $handle);
        $this->setExpectations(TestListenerCallsContractTestExpectation::class, $test);
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
