<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Closure;
use Illuminate\Database\Eloquent\Scope;
use Tests\LaraStrict\Feature\Database\Models\Scopes\TestScope;
use Tests\LaraStrict\Feature\TestCase;

class AbstractEloquentQueryTest extends TestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataScopes(): array
    {
        return [
            'empty' => [
                static fn (self $self) => $self->assertScopes(
                    'select * from "tests" where "tests"."deleted_at" is null',
                    []
                ),
            ],
            'null' => [
                static fn (self $self) => $self->assertScopes(
                    'select * from "tests" where "tests"."deleted_at" is null',
                    [null]
                ),
            ],
            'null and test scope' => [
                static fn (self $self) => $self->assertScopes(
                    'select * from "tests" where "test" = ? and "tests"."deleted_at" is null',
                    [new TestScope(), null]
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataScopes
     */
    public function testScopes(Closure $assert): void
    {
        $assert($this);
    }

    /**
     * @param array<int, Scope|null> $scopes
     */
    public function assertScopes(string $expectedSql, array $scopes): void
    {
        $query = app(TestSqlQuery::class);
        assert($query instanceof TestSqlQuery);

        $this->assertEquals(expected: $expectedSql, actual: $query->execute($scopes));
    }
}
