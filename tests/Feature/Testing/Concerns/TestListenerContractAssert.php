<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use LaraStrict\Testing\AbstractExpectationCallMap;
use PHPUnit\Framework\Assert;

/**
 * @extends AbstractExpectationCallMap<TestListenerContractExpectation>
 */
class TestListenerContractAssert extends AbstractExpectationCallMap implements TestListenerContract
{
    public function handle(TestEvent $event): void
    {
        $expectation = $this->getExpectation();
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->event, $event, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $event, $expectation);
        }
    }
}
