<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

use PHPUnit\Framework\Assert;

class SimpleActionContractAssert extends \LaraStrict\Testing\Assert\AbstractExpectationCallsMap implements SimpleActionContract
{
    /**
     * @param array<SimpleActionContractExpectation|null> $execute
     */
    function __construct(array $execute = [])
    {
        parent::__construct();
        $this->setExpectations(SimpleActionContractExpectation::class, $execute);
    }

    function execute(string $first, int $second, bool $third)
    {
        $expectation = $this->getExpectation(SimpleActionContractExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->first, $first, $message);
        Assert::assertEquals($expectation->second, $second, $message);
        Assert::assertEquals($expectation->third, $third, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $first, $second, $third, $expectation);
        }
    }
}
