<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

use PHPUnit\Framework\Assert;

#[\LaraStrict\Testing\Attributes\Expectation(class: SimpleActionContractExecuteExpectation::class)]
class SimpleActionContractAssert extends \LaraStrict\Testing\Assert\AbstractExpectationCallsMap implements SimpleActionContract
{
    /**
     * @param array<SimpleActionContractExecuteExpectation|null> $execute
     */
    function __construct(array $execute = [])
    {
        parent::__construct();
        $this->setExpectations(SimpleActionContractExecuteExpectation::class, $execute);
    }

    function execute(string $first, int $second, bool $third)
    {
        $_expectation = $this->getExpectation(SimpleActionContractExecuteExpectation::class);
        $_message = $this->getDebugMessage();

        Assert::assertEquals($_expectation->first, $first, $_message);
        Assert::assertEquals($_expectation->second, $second, $_message);
        Assert::assertEquals($_expectation->third, $third, $_message);

        if (is_callable($_expectation->_hook)) {
            call_user_func($_expectation->_hook, $first, $second, $third, $_expectation);
        }
    }
}
