<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models\Casts;

use Closure;
use LaraStrict\Database\Models\Casts\FloatCast;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

class FloatCastTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataEnsureThatFloatIsReturned(): array
    {
        return [
            'decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned('123.00', 123.0),
            ],
            'decimals - long' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    '123.0002',
                    123.0002,
                ),
            ],
            'decimals - short' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned('123.5', 123.5),
            ],
            'no decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned('7', 7.0),
            ],
            'null' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(null, null),
            ],
            'empty string' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned('', null),
            ],
            'non null set to true, null' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    null,
                    0.0,
                    true,
                ),
            ],
            'non null set to true, empty string' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    '',
                    0.0,
                    true,
                ),
            ],
            'non null set to true, decimals' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    '123.00',
                    123.0,
                    true,
                ),
            ],
            'non null set to true, decimals - long' => [
                static fn (self $self) => $self->assertEnsureThatFloatIsReturned(
                    '123.0002',
                    123.0002,
                    true,
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataEnsureThatFloatIsReturned')]
    public function testEnsureThatFloatIsReturned(Closure $assert): void
    {
        $assert($this);
    }

    public function assertEnsureThatFloatIsReturned(
        ?string $value,
        ?float $expected,
        bool $nonNull = false,
    ): void {
        $cast = $nonNull === false ? new FloatCast() : new FloatCast(2, $nonNull);
        $this->assertSame(
            $expected,
            $cast->get(new TestModel(), '', $value, []),
        );
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataConvertFloatToModelDecimalValue(): array
    {
        return [
            '4 decimals - 1' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.0000',
                    new FloatCast(4),
                ),
            ],
            '4 decimals - 2' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.005,
                    '123.0050',
                    new FloatCast(4),
                ),
            ],
            '4 decimals - cut' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.00005,
                    '123.0001',
                    new FloatCast(4),
                ),
            ],
            '2 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.00',
                    new FloatCast(),
                ),
            ],
            '1 decimal' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.0',
                    new FloatCast(1),
                ),
            ],
            '0 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123',
                    new FloatCast(0),
                ),
            ],
            'null' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    null,
                    null,
                    new FloatCast(),
                ),
            ],
            'empty string' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    '',
                    null,
                    new FloatCast(),
                ),
            ],
            'non null, value' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.23,
                    '123.23',
                    new FloatCast(2, true),
                ),
            ],
            'non null, null' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    null,
                    '0.00',
                    new FloatCast(2, true),
                ),
            ],
            'non null, empty string' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    '',
                    '0.00',
                    new FloatCast(2, true),
                ),
            ],
            'non null, 4 decimals - 1' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.0000',
                    new FloatCast(4, true),
                ),
            ],
            'non null, 4 decimals - 2' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.005,
                    '123.0050',
                    new FloatCast(4, true),
                ),
            ],
            'non null, 4 decimals - cut' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.00005,
                    '123.0001',
                    new FloatCast(4, true),
                ),
            ],
            'non null, 2 decimals' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.00',
                    new FloatCast(2, true),
                ),
            ],
            'non null, 1 decimal' => [
                static fn (self $self) => $self->assertConvertFloatToModelDecimalValue(
                    123.0,
                    '123.0',
                    new FloatCast(1, true),
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataConvertFloatToModelDecimalValue')]
    public function testConvertFloatToModelDecimalValue(Closure $assert): void
    {
        $assert($this);
    }

    public function assertConvertFloatToModelDecimalValue(
        float|string|null $value,
        ?string $expected,
        FloatCast $cast,
    ): void {
        $this->assertSame(
            $expected,
            $cast->set(new TestModel(), '', $value, []),
        );
    }
}
