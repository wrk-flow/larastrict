<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Concerns;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;

trait AssertExpectations
{
    abstract public function expectException(string $exception): void;

    abstract public function expectExceptionMessage(string $message): void;

    #[DataProvider('data')]
    public function testEmpty(AssertExpectationEntity $expectation): void
    {
        $this->assertBadCall($expectation->methodName);
        $assert = self::createEmptyAssert();

        $this->callExpectation($expectation, $assert);
    }

    #[DataProvider('data')]
    public function testCallsWithSecondFails(AssertExpectationEntity $expectation): void
    {
        /** @var AbstractExpectationCallsMap $assert */
        $assert = call_user_func($expectation->createAssert, $expectation->createAssert);

        $result = $this->callExpectation($expectation, $assert);

        if ($expectation->checkResult) {
            $expectedResult = $expectation->checkResultIsSelf ? $assert : $expectation->expectedResult;
            $this->assertSame($expectedResult, $result);
        }

        $this->assertBadCall(method: $expectation->methodName, callNumber: 2);
        $this->callExpectation($expectation, $assert);
    }

    public static function data(): array
    {
        $data = [];
        foreach (self::generateData() as $index => $test) {
            $data[$test->methodName . ' #' . $index] = [$test];
        }

        return $data;
    }

    /**
     * @return array<AssertExpectationEntity>
     */
    abstract static protected function generateData(): array;

    abstract protected function createEmptyAssert(): AbstractExpectationCallsMap;

    protected function assertBadCall(string $method, int $callNumber = 1): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($method . '] not set for a n (' . $callNumber . ') call');
    }

    protected function callExpectation(AssertExpectationEntity $expectation, AbstractExpectationCallsMap $assert): mixed
    {
        return call_user_func($expectation->call, $assert);
    }
}
