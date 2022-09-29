<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Database\Contracts;

use LaraStrict\Testing\Database\Contracts\SafeUniqueSaveActionContractAssert;
use LaraStrict\Testing\Database\Contracts\SafeUniqueSaveActionContractExpectation;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Database\Models\Test;

class SafeUniqueSaveActionContractAssertTest extends TestCase
{
    public function testExecuteOneTry(): void
    {
        $model = new Test();
        $expectations = [new SafeUniqueSaveActionContractExpectation($model)];
        $expectedResult = 'test1';

        $this->assertExecute($expectations, $model, $expectedResult);
    }

    public function testExecuteTwoTries(): void
    {
        $model = new Test();
        $expectations = [
            new SafeUniqueSaveActionContractExpectation($model, fail: true),
            new SafeUniqueSaveActionContractExpectation($model, tries: 2),
        ];
        $expectedResult = 'test2';

        $this->assertExecute($expectations, $model, $expectedResult);
    }

    protected function assertExecute(array $expectations, Test $model, string $expectedResult): void
    {
        $assert = new SafeUniqueSaveActionContractAssert($expectations);

        $calls = 0;
        $result = $assert->execute($model, function (Test $model, int $tries) use (&$calls) {
            ++$calls;
            $this->assertEquals($calls, $tries);
            return 'test' . $calls;
        });

        $this->assertEquals($expectedResult, $result);
    }
}
