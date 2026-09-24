<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use LaraStrict\Testing\PHPUnit\ResourceTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Http\Resources\LaraStrictResource;
use Tests\LaraStrict\Feature\Http\Resources\TestAction;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @extends ResourceTestCase<TestEntity>
 */
class LaraStrictResourceTestCaseTest extends ResourceTestCase
{
    public static function data(): array
    {
        return [
            [
                static fn (self $testCase) => $testCase->myAssert('test', '2'),
            ],
            [
                static fn (self $testCase) => $testCase->myAssert('test22', '1'),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('data')]
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    public function testResourceArray(): void
    {
        $resource = $this->createResource(new TestEntity('test'));

        $this->assertEquals(
            self::expected('test', '1'),
            $this->resourceArray($resource, $this->createContainer('1')),
        );
    }

    public function testResourceArrayCollection(): void
    {
        $resource = LaraStrictResource::collection([new TestEntity('test')]);

        $this->assertEquals(
            [self::expected('test', '1')],
            $this->resourceArray($resource, $this->createContainer('1')),
        );
    }

    public function testResourceArrayNull(): void
    {
        $this->assertNull($this->resourceArray(null, $this->createContainer('1')));
        $this->assertNull($this->resourceArray(null));
    }

    protected function myAssert(string $value, string $instance): void
    {
        $this->assert(
            new TestEntity($value),
            self::expected($value, $instance),
            $this->createContainer($instance),
        );
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new LaraStrictResource($object);
    }

    protected static function createContainer(string $instance): TestingContainer
    {
        return new TestingContainer([], static fn () => new TestAction($instance));
    }

    /**
     * @return array<array-key, mixed>
     */
    protected static function expected(string $value, string $instance): array
    {
        return [
            'test' => $value,
            'instance' => $instance,
        ];
    }
}
