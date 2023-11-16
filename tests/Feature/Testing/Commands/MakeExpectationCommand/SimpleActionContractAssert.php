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
        $_expectation = $this->getExpectation(SimpleActionContractExpectation::class);
        $_message = $this->getDebugMessage();

        Assert::assertEquals($_expectation->first, $first, $_message);
        Assert::assertEquals($_expectation->second, $second, $_message);
        Assert::assertEquals($_expectation->third, $third, $_message);

        if (is_callable($_expectation->_hook)) {
            call_user_func($_expectation->_hook, $first, $second, $third, $_expectation);
        }
    }
}
