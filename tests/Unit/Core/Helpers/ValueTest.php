<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Core\Helpers;

use LaraStrict\Core\Helpers\Value;
use PHPUnit\Framework\TestCase;

final class ValueTest extends TestCase
{
    /**
     * @dataProvider provideValueToFloat
     */
    public function testValueToFloat(string|float|int $actual, ?float $expected): void
    {
        $this->assertSame($expected, Value::toFloat($actual));
    }

    public function provideValueToFloat(): array
    {
        return [
            ['', null],
            ['.', null],
            [',', null],
            ['a', null],
            ['0', 0.0],
            ['-.0', 0.0],
            ['-0.', 0.0],
            ['-0', 0.0],
            ['+0', 0.0],
            ['0.0', 0.0],
            ['0.5', 0.5],
            ['0,5', 0.5],
            ['-0,5', -0.5],
            ['-,5', -0.5],
            ['+0,5', 0.5],
            ['+,5', 0.5],
            [0, 0.0],
            [0.0, 0.0],
            [1.5, 1.5],
            ['9223372036854775807', 9.223372036854776E+18],
            ['9223372036854775807.5', 9.223372036854776E+18],
            ['922337203685477580703434355.5', 9.223372036854776E+26],
            ['-922337203685477580703434355.5', -9.223372036854776E+26],
        ];
    }
}
