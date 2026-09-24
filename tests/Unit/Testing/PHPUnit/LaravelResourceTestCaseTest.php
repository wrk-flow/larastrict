<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\Laravel\TestingContainer;
use LaraStrict\Testing\PHPUnit\ResourceTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @extends ResourceTestCase<TestEntity>
 */
class LaravelResourceTestCaseTest extends ResourceTestCase
{
    public static function data(): array
    {
        return [
            [
                static fn (self $testCase) => $testCase->assert(
                    new TestEntity('test'),
                    self::expected('test'),
                ),
            ],
            [
                static fn (self $testCase) => $testCase->assert(
                    new TestEntity('test22'),
                    self::expected('test22'),
                ),
            ],
            'fail while setting container' => [
                static fn (self $testCase) => $testCase->assert(
                    new TestEntity('test'),
                    self::containerCannotBeSetException(),
                    new TestingContainer(),
                ),
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
            self::expected('test'),
            $this->resourceArray($resource),
        );
    }

    public function testResourceArrayCollection(): void
    {
        $resource = LaravelResource::collection([new TestEntity('test')]);

        $this->assertEquals(
            [self::expected('test')],
            $this->resourceArray($resource),
        );
    }

    public function testResourceArrayFailOnContainer(): void
    {
        $resource = $this->createResource(new TestEntity('test'));

        $this->expectExceptionObject(self::containerCannotBeSetException());
        $this->resourceArray($resource, new TestingContainer());
    }

    public function testResourceArrayCollectionFailOnContainer(): void
    {
        $resource = $this->createResource(new TestEntity('test'));

        $this->expectExceptionObject(self::containerCannotBeSetException());
        $this->resourceArray($resource, new TestingContainer());
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new LaravelResource($object);
    }

    /**
     * @return array<array-key, mixed>
     */
    protected static function expected(string $value): array
    {
        return [
            'test' => $value,
        ];
    }
}
