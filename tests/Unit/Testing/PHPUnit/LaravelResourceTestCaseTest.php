<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use LaraStrict\Testing\PHPUnit\ResourceTestCase;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @extends ResourceTestCase<TestEntity>
 */
class LaravelResourceTestCaseTest extends ResourceTestCase
{
    public function data(): array
    {
        return [
            [
                static fn (self $testCase) => $testCase->assert(
                    object: new TestEntity(value: 'test'),
                    expected: self::expect(value: 'test')
                ),
            ],
            [
                static fn (self $testCase) => $testCase->assert(
                    object: new TestEntity(value: 'test22'),
                    expected: self::expect(value: 'test22')
                ),
            ],
            'fail while setting container' => [
                static fn (self $testCase) => $testCase->assert(
                    object: new TestEntity(value: 'test'),
                    expected: self::containerCannotBeSetException(),
                    container: new TestingContainer(),
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     * @dataProvider data
     */
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new LaravelResource($object);
    }

    protected static function expect(string $value): array
    {
        return [
            'test' => $value,
        ];
    }
}
