<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use LaraStrict\Database\Scopes\WhereIdsScope;
use LaraStrict\Tests\Traits\SqlTestEnable;
use Tests\LaraStrict\Feature\Database\Models\Scopes\TestScope;
use Tests\LaraStrict\Feature\TestCase;

class AbstractEloquentQueryTest extends TestCase
{
    use SqlTestEnable;

    public function dataScopes(): array
    {
        return [
            'empty' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "tests"."deleted_at" is null',
                    scopes: [],
                    class: $class,
                ),
            ],
            'null' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "tests"."deleted_at" is null',
                    scopes: [null],
                    class: $class,
                ),
            ],
            'null and test scope' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "test" = ? and "tests"."deleted_at" is null',
                    scopes: [new TestScope(), null],
                    class: $class,
                ),
            ],
        ];
    }

    /**
     * @param Closure(static $assert, class-string<TestSqlQueryContract> $class):void $assert
     *
     * @dataProvider dataScopes
     */
    public function testScopes(Closure $assert): void
    {
        $assert($this, TestSqlQuery::class);
    }

    /**
     * @param array<int, Scope|null> $scopes
     */
    public function assertScopes(string $expectedSql, array $scopes, string $class): void
    {
        /** @var object $query */
        $query = app($class);
        $this->assertInstanceOf(expected: TestSqlQueryContract::class, actual: $query);
        $this->assertEquals(expected: $expectedSql, actual: $query->execute($scopes));
    }

    /**
     * @param Closure(static $assert, class-string<TestSqlQueryContract> $class):void $assert
     * @dataProvider dataScopes
     */
    public function testChunkScopes(Closure $assert): void
    {
        $assert($this, TestChunkSqlQuery::class);
    }

    public function testFindOrFail(): void
    {
        $this->assertSql(fn () => (new class() extends AbstractTestQuery {
            public function execute(): Model
            {
                return $this->findOrFail(1);
            }
        })->execute(), 'select * from "tests" where "tests"."id" = 1 and "tests"."deleted_at" is null limit 1');
    }

    public function testFirstOrFail(): void
    {
        $this->assertSql(fn () => (new class() extends AbstractTestQuery {
            public function execute(): Model
            {
                return $this->firstOrFail([new WhereIdsScope(2)]);
            }
        })->execute(), 'select * from "tests" where "tests"."id" = 2 and "tests"."deleted_at" is null limit 1');
    }
}
