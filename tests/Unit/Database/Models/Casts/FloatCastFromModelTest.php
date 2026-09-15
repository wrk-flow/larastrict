<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Database\Models\Casts;

use Closure;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

final class FloatCastFromModelTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function data(): array
    {
        $value = '123.455555555';
        return [
            'non null, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloatNonNull,
                    $value,
                    123.46,
                ),
            ],
            'non null, with null value returns 0.0' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloatNonNull,
                    null,
                    0.0,
                ),
            ],
            'nullable default, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat,
                    $value,
                    123.46,
                ),
            ],
            'nullable default, with null value returns null' => [
                static fn (self $self) => $self->assert(
                    'float_non_null',
                    null,
                    null,
                ),
            ],
            '1 decimal, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat1Decimals,
                    $value,
                    123.5,
                ),
            ],
            '1 decimal, with null value returns null' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat1Decimals,
                    null,
                    null,
                ),
            ],
            '3 decimals, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat3Decimals,
                    $value,
                    123.456,
                ),
            ],
            '3 decimals, with null value returns null' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat3Decimals,
                    null,
                    null,
                ),
            ],
            '4 decimals, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat4Decimals,
                    $value,
                    123.4556,
                ),
            ],
            '4 decimals, with null value returns null' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat4Decimals,
                    null,
                    null,
                ),
            ],
            '1 decimal non null, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat1DecimalsNonNull,
                    $value,
                    123.5,
                ),
            ],
            '1 decimal non null, with null value returns 0.0' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat1DecimalsNonNull,
                    null,
                    0.0,
                ),
            ],
            '3 decimals non null, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat3DecimalsNonNull,
                    $value,
                    123.456,
                ),
            ],
            '3 decimals non null, with null value returns 0.0' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat3DecimalsNonNull,
                    null,
                    0.0,
                ),
            ],
            '4 decimals non null, with value' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat4DecimalsNonNull,
                    $value,
                    123.4556,
                ),
            ],
            '4 decimals non null, with null value returns 0.0' => [
                static fn (self $self) => $self->assert(
                    TestModel::AttributeFloat4DecimalsNonNull,
                    null,
                    0.0,
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

    public function assert(string $attribute, ?string $setValue, ?float $expectedValue): void
    {
        $test = new TestModel();
        $test->setAttribute($attribute, $setValue);

        $this->assertEquals($expectedValue, $test->getAttribute($attribute));
    }
}
