<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\PHPUnit\ModelResourceTestCase;
use Tests\LaraStrict\Feature\Http\Resources\TestEntity;

/**
 * @extends ModelResourceTestCase<TestEntity>
 */
class ModelResourceTestCaseWithEntityTest extends ModelResourceTestCase
{
    public function data(): array
    {
        return [
            [
                static fn (self $self) => $self->assert(
                    object: self::create(value: 1),
                    expected: self::expect(value: 1)
                ),
            ],
            [
                static fn (self $self) => $self->assert(
                    object: self::create(value: 2),
                    expected: self::expect(value: 2)
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

    private static function expect(int $value): array
    {
        return [
            'test' => (string) $value,
        ];
    }

    private static function create(int $value): TestEntity
    {
        return new TestEntity(value: (string) $value);
    }
}
