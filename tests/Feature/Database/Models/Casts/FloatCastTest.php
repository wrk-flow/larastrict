<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models\Casts;

use Closure;
use LaraStrict\Database\Models\Casts\FloatCast;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Database\Models\Test;

class FloatCastTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataEnsureThatFloatIsReturned(): array
    {
        return [
            'decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(value: '123.00', expected: 123.0),
            ],
            'decimals - long' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    value: '123.0002',
                    expected: 123.0002,
                ),
            ],
            'decimals - short' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(value: '123.5', expected: 123.5),
            ],
            'no decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(value: '7', expected: 7.0),
            ],
            'null' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(value: null, expected: null),
            ],
            'empty string' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(value: '', expected: null),
            ],
            'non null set to true, null' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    value: null,
                    expected: 0.0,
                    nonNull: true
                ),
            ],
            'non null set to true, empty string' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    value: '',
                    expected: 0.0,
                    nonNull: true
                ),
            ],
            'non null set to true, decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    value: '123.00',
                    expected: 123.0,
                    nonNull: true,
                ),
            ],
            'non null set to true, decimals - long' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    value: '123.0002',
                    expected: 123.0002,
                    nonNull: true,
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataEnsureThatFloatIsReturned
     */
    public function testEnsureThatFloatIsReturned(Closure $assert): void
    {
        $assert($this);
    }

    public function assertEnsureThatFloatIsReturned(
        ?string $value,
        ?float $expected,
        bool $nonNull = false
    ): void {
        $cast = $nonNull === false ? new FloatCast() : new FloatCast(nonNull: $nonNull);
        $this->assertSame(
            expected: $expected,
            actual: $cast->get(model: new Test(), key: '', value: $value, attributes: []),
        );
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataConvertFloatToModelDecimalValue(): array
    {
        return [
            '4 decimals - 1' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.0000',
                    cast: new FloatCast(4),
                ),
            ],
            '4 decimals - 2' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.005,
                    expected: '123.0050',
                    cast: new FloatCast(4),
                ),
            ],
            '4 decimals - cut' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.00005,
                    expected: '123.0001',
                    cast: new FloatCast(4),
                ),
            ],
            '2 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.00',
                    cast: new FloatCast(),
                ),
            ],
            '1 decimal' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.0',
                    cast: new FloatCast(1),
                ),
            ],
            '0 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123',
                    cast: new FloatCast(0),
                ),
            ],
            'null' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: null,
                    expected: null,
                    cast: new FloatCast(),
                ),
            ],
            'empty string' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: '',
                    expected: null,
                    cast: new FloatCast(),
                ),
            ],
            'non null, value' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.23,
                    expected: '123.23',
                    cast: new FloatCast(nonNull: true),
                ),
            ],
            'non null, null' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: null,
                    expected: '0.00',
                    cast: new FloatCast(nonNull: true),
                ),
            ],
            'non null, empty string' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: '',
                    expected: '0.00',
                    cast: new FloatCast(nonNull: true),
                ),
            ],
            'non null, 4 decimals - 1' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.0000',
                    cast: new FloatCast(decimals: 4, nonNull: true),
                ),
            ],
            'non null, 4 decimals - 2' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.005,
                    expected: '123.0050',
                    cast: new FloatCast(decimals: 4, nonNull: true),
                ),
            ],
            'non null, 4 decimals - cut' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.00005,
                    expected: '123.0001',
                    cast: new FloatCast(decimals: 4, nonNull: true),
                ),
            ],
            'non null, 2 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.00',
                    cast: new FloatCast(decimals: 2, nonNull: true),
                ),
            ],
            'non null, 1 decimal' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    value: 123.0,
                    expected: '123.0',
                    cast: new FloatCast(decimals: 1, nonNull: true),
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     * @dataProvider dataConvertFloatToModelDecimalValue
     */
    public function testConvertFloatToModelDecimalValue(Closure $assert): void
    {
        $assert($this);
    }

    public function assertConvertFloatToModelDecimalValue(
        float|string|null $value,
        ?string $expected,
        FloatCast $cast
    ): void {
        $this->assertSame(
            expected: $expected,
            actual: $cast->set(model: new Test(), key: '', value: $value, attributes: []),
        );
    }
}
