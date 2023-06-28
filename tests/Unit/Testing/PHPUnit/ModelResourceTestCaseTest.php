<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\PHPUnit;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraStrict\Testing\PHPUnit\ModelResourceTestCase;
use Tests\LaraStrict\Feature\Database\Models\Test;

/**
 * @extends ModelResourceTestCase<Test>
 */
class ModelResourceTestCaseTest extends ModelResourceTestCase
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

    protected function createResource(object $object): JsonResource
    {
        return new ModelResource($object);
    }

    private static function expect(int $value): array
    {
        return [
            'test' => $value,
        ];
    }

    private static function create(int $value): Test
    {
        $test = new Test();
        $test->test = $value;
        // Should trigger mock models
        $test->deleted_at = Carbon::now();

        return $test;
    }
}
