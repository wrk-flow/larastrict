<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing;

use LaraStrict\Testing\Assert\AssertExpectationManager;
use LaraStrict\Testing\Assert\AssertExpectationTestCase;
use PHPUnit\Framework\AssertionFailedError;

class AbstractExpectationCallMapTest extends AssertExpectationTestCase
{
    private ?string $expectManagerExceptionMessage = null;

    public function testSupportsNullableArray(): void
    {
        $this->expectExceptionMessage(
            'Expectation for [Tests\LaraStrict\Unit\Testing\TestExpectationCallMap@execute] not set for a n (3) call',
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

    public function testSupportsReset(): void
    {
        $testExpectation1 = new TestExpectation(0);
        $testExpectation2 = new TestExpectation(1);
        $map = new TestExpectationCallMap([$testExpectation1, $testExpectation2]);

        $map->execute($testExpectation1);
        $map->execute($testExpectation2);

        $map->setExpectations(TestExpectation::class, [$testExpectation2]);
        $map->execute($testExpectation2);
    }

    public function testEmptyExpectation(): void
    {
        new TestExpectationCallMap();
    }

    public function testManagerAssertCalledShouldBeCalled(): void
    {
        $this->expectManagerExceptionMessage = '[Tests\LaraStrict\Unit\Testing\TestExpectation] expected 1 call/s but was called <0> time/s';
        new TestExpectationCallMap([new TestExpectation(1)]);
    }

    public function testManagerAssertCalledShouldBeCalledTwice(): void
    {
        $this->expectCalledTwice();
        $testExpectation1 = new TestExpectation(0);
        $testExpectation2 = new TestExpectation(1);
        $map = new TestExpectationCallMap([$testExpectation1, $testExpectation2]);
        $map->execute($testExpectation1);
    }

    public function testAddExpectation(): void
    {
        $testExpectation1 = new TestExpectation(0);
        $testExpectation2 = new TestExpectation(1);
        $map = new TestExpectationCallMap([]);

        $map->addExpectation($testExpectation1);
        $map->execute($testExpectation1);
        $map->addExpectation($testExpectation2);
        $map->execute($testExpectation2);
    }

    public function testAddExpectationWithError(): void
    {
        $testExpectation1 = new TestExpectation(0);
        $testExpectation2 = new TestExpectation(1);
        $map = new TestExpectationCallMap();

        $map->addExpectation($testExpectation1);
        $map->execute($testExpectation1);
        $map->addExpectation($testExpectation2);

        $this->expectCalledTwice();
    }

    public function testNullConstructIsFiltered(): void
    {
        $testExpectation1 = new TestExpectation(0);
        $map = new TestExpectationCallMap([null, $testExpectation1]);
        $map->execute($testExpectation1);
    }

    public function testSetExpectationsFiltered(): void
    {
        $testExpectation1 = new TestExpectation(0);
        $map = new TestExpectationCallMap();
        $map->setExpectations(TestExpectation::class, [null, $testExpectation1]);
        $map->execute($testExpectation1);
    }

    /**
     * aaa prefix is for sort hook above
     *
     * @postCondition
     */
    protected function aaaPostConditions(): void
    {
        if ($this->expectManagerExceptionMessage === null) {
            return;
        }

        try {
            AssertExpectationManager::getInstance()->assertCalled();
        } catch (AssertionFailedError $assertionFailedError) {
            $this->assertEquals($this->expectManagerExceptionMessage, $assertionFailedError->getMessage());
        }
        AssertExpectationManager::getInstance()->reset();
    }

    protected function expectCalledTwice(): void
    {
        $this->expectManagerExceptionMessage = '[Tests\LaraStrict\Unit\Testing\TestExpectation] expected 2 call/s but was called <1> time/s';
    }
}
