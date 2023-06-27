<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class TestExpectationCallMap extends AbstractExpectationCallsMap
{
    /**
     * @param array<TestExpectation|null> $expectations
     */
    public function __construct(array $expectations = [])
    {
        parent::__construct();
        $this->setExpectations(TestExpectation::class, $expectations);
    }

    public function execute(TestExpectation $testExpectation): void
    {
        Assert::assertSame($testExpectation, $this->getExpectation(TestExpectation::class));
    }
}
