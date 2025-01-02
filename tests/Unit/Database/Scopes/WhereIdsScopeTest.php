<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Database\Scopes;

use Closure;
use LaraStrict\Database\Scopes\WhereIdsScope;
use LaraStrict\Tests\Traits\SqlTestEnable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Unit\Database\Services\TestModel;

class WhereIdsScopeTest extends TestCase
{
    use SqlTestEnable;

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public static function data(): array
    {
        return [
            [
                static function (self $self) {
                    $self->assert(new WhereIdsScope(1), 'select * from "test_models" where "test_models"."id" = ?');
                },
            ],
            [
                static function (self $self) {
                    $self->assert(new WhereIdsScope([1]), 'select * from "test_models" where "test_models"."id" = ?');
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new WhereIdsScope([1], not: true),
                        'select * from "test_models" where "test_models"."id" != ?',
                    );
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new WhereIdsScope([1, 2]),
                        'select * from "test_models" where "test_models"."id" in (?, ?)'
                    );
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new WhereIdsScope([1, 2], 'foo'),
                        'select * from "test_models" where "test_models"."foo" in (?, ?)',
                    );
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new WhereIdsScope([1, 2], table: 'foo'),
                        'select * from "test_models" where "foo"."id" in (?, ?)',
                    );
                },
            ],
            [
                static function (self $self) {
                    $self->assert(
                        new WhereIdsScope([1, 2], not: true),
                        'select * from "test_models" where "test_models"."id" not in (?, ?)',
                    );
                },
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

    public function assert(WhereIdsScope $scope, string $expected): void
    {
        $builder = TestModel::query();
        $scope->apply($builder, new TestModel());

        $sql = $builder->toSql();
        Assert::assertSame($expected, $sql);
    }
}
