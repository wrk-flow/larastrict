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
                static fn (self $self) => $self->assert(direction: 'ASC', expectedDirection: 'ASC'),
            ],
            [
                static fn (self $self) => $self->assert(direction: 'DESC', expectedDirection: 'DESC'),
            ],
            [
                static fn (self $self) => $self->assert(direction: 'desc', expectedDirection: 'DESC'),
            ],
            [
                static fn (self $self) => $self->assert(direction: 'asc', expectedDirection: 'ASC'),
            ],
            [
                static fn (self $self) => $self->assert(direction: null, expectedDirection: 'ASC'),
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
            expected: 'select * from "tests" order by FIELD(`test`, ?, ?, ?) ' . $expectedDirection,
            actual: $query->toSql()
        );

        $this->assertEquals(expected: $values, actual: $query->getBindings());
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function dataInvalid(): array
    {
        return [
            [
                static fn (self $self) => $self->assertInvalid(direction: 'invalid'),
            ],
            [
                static fn (self $self) => $self->assertInvalid(direction: 'asio'),
            ],

            [
                static fn (self $self) => $self->assertInvalid(direction: 'descio'),
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
