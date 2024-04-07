<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\PHPUnit\ModelResourceTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

/**
 * @extends ModelResourceTestCase<TestModel>
 */
class ModelResourceTestCaseTest extends ModelResourceTestCase
{
    public static function data(): array
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
     */
    #[DataProvider('data')]
    public function test(Closure $assert): void
    {
        $assert($this);
    }

    protected function createResource(mixed $object): JsonResource
    {
        return new ModelResource($object);
    }

    private static function expect(int $value): array
    {
        return [
            'test' => $value,
        ];
    }

    private static function create(int $value): TestModel
    {
        $test = new TestModel();
        $test->test = $value;
        // Should trigger mock models
        $test->deleted_at = Carbon::now();

        return $test;
    }
}
