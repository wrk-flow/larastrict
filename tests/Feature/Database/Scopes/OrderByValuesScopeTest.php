<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use Closure;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraStrict\Database\Scopes\OrderByValuesScope;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Database\Models\TestModel;
use Tests\LaraStrict\Feature\TestCase;

class OrderByValuesScopeTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function data(): array
    {
        return [
            [
                static fn (self $self) => $self->assert('ASC', 'ASC'),
            ],
            [
                static fn (self $self) => $self->assert('DESC', 'DESC'),
            ],
            [
                static fn (self $self) => $self->assert('desc', 'DESC'),
            ],
            [
                static fn (self $self) => $self->assert('asc', 'ASC'),
            ],
            [
                static fn (self $self) => $self->assert(null, 'ASC'),
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

    public function assert(?string $direction, string $expectedDirection): void
    {
        $values = ['1', 2, 's33'];
        $scope = $direction === null
            ? new OrderByValuesScope($values, TestModel::AttributeTest)
            : new OrderByValuesScope($values, TestModel::AttributeTest, $direction);

        $query = TestModel::query()
            ->withoutGlobalScope(new SoftDeletingScope())
            ->withGlobalScope('test', $scope);

        $this->assertEquals(
            'select * from "tests" order by FIELD(`test`, ?, ?, ?) ' . $expectedDirection,
            $query->toSql(),
        );

        $this->assertEquals($values, $query->getBindings());
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataInvalid(): array
    {
        return [
            [
                static fn (self $self) => $self->assertInvalid('invalid'),
            ],
            [
                static fn (self $self) => $self->assertInvalid('asio'),
            ],

            [
                static fn (self $self) => $self->assertInvalid('descio'),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     */
    #[DataProvider('dataInvalid')]
    public function testInvalid(Closure $assert): void
    {
        $assert($this);
    }

    public function assertInvalid(string $direction): void
    {
        $this->expectExceptionMessage('Direction must be ASC or DESC');
        new OrderByValuesScope([], TestModel::AttributeTest, $direction);
    }
}
