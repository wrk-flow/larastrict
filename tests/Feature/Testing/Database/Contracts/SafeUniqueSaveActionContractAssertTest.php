<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Database\Contracts;

use LaraStrict\Testing\Database\Contracts\SafeUniqueSaveActionContractAssert;
use LaraStrict\Testing\Database\Contracts\SafeUniqueSaveActionContractExpectation;
use Tests\LaraStrict\Feature\Database\Models\TestModel;
use Tests\LaraStrict\Feature\Database\Models\TestNoDates;
use Tests\LaraStrict\Feature\TestCase;

class SafeUniqueSaveActionContractAssertTest extends TestCase
{
    public function testExecuteOneTry(): void
    {
        $model = new TestModel();
        $expectations = [new SafeUniqueSaveActionContractExpectation($model)];
        $expectedResult = 'test1';

        $this->assertExecute($expectations, $model, $expectedResult);
    }

    public function testExecuteOneTryNoDates(): void
    {
        $model = new TestNoDates();
        $expectations = [new SafeUniqueSaveActionContractExpectation($model)];
        $expectedResult = 'test1';

        $this->assertExecute($expectations, $model, $expectedResult);
    }

    public function testExecuteOneTryWithSetId(): void
    {
        $model = new TestModel();
        $expectations = [new SafeUniqueSaveActionContractExpectation($model, setId: 1)];
        $expectedResult = 'test1';

        $this->assertExecute($expectations, $model, $expectedResult, 1);
    }

    public function testExecuteTwoTries(): void
    {
        $model = new TestModel();
        $expectations = [
            new SafeUniqueSaveActionContractExpectation($model, fail: true),
            new SafeUniqueSaveActionContractExpectation($model, tries: 2),
        ];
        $expectedResult = 'test2';

        $this->assertExecute($expectations, $model, $expectedResult);
    }

    public function testExecuteTwoTriesWithId(): void
    {
        $model = new TestModel();
        $expectations = [
            new SafeUniqueSaveActionContractExpectation($model, fail: true, setId: 2),
            new SafeUniqueSaveActionContractExpectation($model, tries: 2, setId: 1),
        ];
        $expectedResult = 'test2';

        $this->assertExecute($expectations, $model, $expectedResult, 1);
    }

    protected function assertExecute(
        array $expectations,
        TestModel|TestNoDates $model,
        string $expectedResult,
        ?int $expectedId = null
    ): void {
        $assert = new SafeUniqueSaveActionContractAssert($expectations);

        $calls = 0;
        $result = $assert->execute($model, function (TestModel|TestNoDates $model, int $tries) use (&$calls) {
            ++$calls;
            $this->assertEquals($calls, $tries);
            return 'test' . $calls;
        });

        $this->assertEquals($expectedResult, $result);

        $createdAt = $model->getAttribute('created_at');
        $updatedAt = $model->getAttribute('updated_at');
        if ($model instanceof TestNoDates) {
            $this->assertNull($createdAt);
            $this->assertNull($updatedAt);
        } else {
            $this->assertNotNull($createdAt);
            $this->assertNotNull($updatedAt);
        }

        $this->assertEquals($expectedId, $model->getKey());

        if ($expectedId !== null) {
            $this->assertEquals(true, $model->exists);
            $this->assertEquals(true, $model->wasRecentlyCreated);
        }
    }
}
