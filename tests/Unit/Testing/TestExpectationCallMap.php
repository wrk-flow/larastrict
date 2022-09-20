<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing;

use LaraStrict\Testing\AbstractExpectationCallMap;
use PHPUnit\Framework\Assert;

/**
 * @extends AbstractExpectationCallMap<TestExpectation>
 */
class TestExpectationCallMap extends AbstractExpectationCallMap
{
    public function execute(TestExpectation $testExpectation): void
    {
        Assert::assertSame($testExpectation, $this->getExpectation());
    }
}
