<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use LaraStrict\Testing\PHPUnit\ResourceTestCase;
use Tests\LaraStrict\Feature\Http\Resources\LaraStrictResource;
use Tests\LaraStrict\Feature\Http\Resources\TestAction;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @extends ResourceTestCase<array<TestEntity>>
 */
class LaraStrictResourcesTestCaseTest extends ResourceTestCase
{
    public function data(): array
    {
        return [
            [
                static fn (self $testCase) => $testCase->myAssert(value: 'test', instance: '2'),
            ],
            [
                static fn (self $testCase) => $testCase->myAssert(value: 'test22', instance: '1'),
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

    protected function myAssert(string $value, string $instance): void
    {
        $this->assert(
            object: [new TestEntity(value: $value)],
            expected: [
                [
                    'test' => $value,
                    'instance' => $instance,
                ],
            ],
            container: new TestingContainer(
                makeAlwaysBinding: static fn () => new TestAction($instance)
            ),
        );
    }

    protected function createResource(mixed $object): JsonResource
    {
        return LaraStrictResource::collection($object);
    }

    protected static function createContainer(string $value): TestingContainer
    {
        return new TestingContainer(
            makeAlwaysBinding: static fn () => new TestAction($value)
        );
    }
}
