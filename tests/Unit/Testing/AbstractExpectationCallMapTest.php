<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing;

use PHPUnit\Framework\TestCase;

class AbstractExpectationCallMapTest extends TestCase
{
    public function testSupportsNullableArray(): void
    {
        $this->expectExceptionMessage(
            'Expectation for [Tests\LaraStrict\Unit\Testing\TestExpectationCallMap@execute] not set for a n (3) call'
        );

        $testExpectation1 = new TestExpectation(0);
        $testExpectation2 = new TestExpectation(1);
        $map = new TestExpectationCallMap([
            '1' => $testExpectation1,
            null,
            '3' => $testExpectation2,
        ]);

        $map->execute($testExpectation1);
        $map->execute($testExpectation2);
        $map->execute($testExpectation2);
    }
}
