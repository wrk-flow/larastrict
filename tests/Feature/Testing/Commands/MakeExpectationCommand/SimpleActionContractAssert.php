<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

use PHPUnit\Framework\Assert;

/**
 * @extends \LaraStrict\Testing\AbstractExpectationCallMap<\Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContractExpectation>
 */
class SimpleActionContractAssert extends \LaraStrict\Testing\AbstractExpectationCallMap implements SimpleActionContract
{
    function execute(string $first, int $second, bool $third)
    {
        $expectation = $this->getExpectation();
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->first, $first, $message);
        Assert::assertEquals($expectation->second, $second, $message);
        Assert::assertEquals($expectation->third, $third, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $first, $second, $third, $expectation);
        }
    }
}
