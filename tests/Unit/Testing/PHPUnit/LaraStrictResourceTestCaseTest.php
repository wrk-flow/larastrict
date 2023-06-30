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
 * @extends ResourceTestCase<TestEntity>
 */
class LaraStrictResourceTestCaseTest extends ResourceTestCase
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

    public function testResourceArray(): void
    {
        $resource = $this->createResource(new TestEntity(value: 'test'));

        $this->assertEquals(
            expected: self::expected(value: 'test', instance: '1'),
            actual: $this->resourceArray(resource: $resource, container: $this->createContainer(instance: '1'))
        );
    }

    public function testResourceArrayCollection(): void
    {
        $resource = LaraStrictResource::collection([new TestEntity(value: 'test')]);

        $this->assertEquals(
            expected: [self::expected(value: 'test', instance: '1')],
            actual: $this->resourceArray(resource: $resource, container: $this->createContainer(instance: '1'))
        );
    }

    public function testResourceArrayNull(): void
    {
        $this->assertNull($this->resourceArray(resource: null, container: $this->createContainer(instance: '1')));
        $this->assertNull($this->resourceArray(resource: null));
    }

    protected function myAssert(string $value, string $instance): void
    {
        $this->assert(
            object: new TestEntity(value: $value),
            expected: self::expected($value, $instance),
            container: $this->createContainer($instance),
        );
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new LaraStrictResource($object);
    }

    protected static function createContainer(string $instance): TestingContainer
    {
        return new TestingContainer(
            makeAlwaysBinding: static fn () => new TestAction($instance)
        );
    }

    protected static function expected(string $value, string $instance): array
    {
        return [
            'test' => $value,
            'instance' => $instance,
        ];
    }
}
