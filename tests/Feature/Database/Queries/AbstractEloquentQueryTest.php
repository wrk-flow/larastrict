<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Closure;
use Illuminate\Database\Eloquent\Scope;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\LaraStrict\Feature\Database\Models\Scopes\TestScope;
use Tests\LaraStrict\Feature\TestCase;

class AbstractEloquentQueryTest extends TestCase
{
    public static function dataScopes(): array
    {
        return [
            'empty' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "tests"."deleted_at" is null',
                    scopes: [],
                    class: $class
                ),
            ],
            'null' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "tests"."deleted_at" is null',
                    scopes: [null],
                    class: $class
                ),
            ],
            'null and test scope' => [
                static fn (self $self, string $class) => $self->assertScopes(
                    expectedSql: 'select * from "tests" where "test" = ? and "tests"."deleted_at" is null',
                    scopes: [new TestScope(), null],
                    class: $class
                ),
            ],
        ];
    }

    /**
     * @param Closure(static $assert, class-string<TestSqlQueryContract> $class):void $assert
     */
    #[DataProvider('dataScopes')]
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
     */
    #[DataProvider('dataScopes')]
    public function testChunkScopes(Closure $assert): void
    {
        $assert($this, TestChunkSqlQuery::class);
    }
}
