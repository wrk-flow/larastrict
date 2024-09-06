<?php

declare(strict_types=1);

namespace LaraStrict\Tests\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\SQLiteConnection;
use PDO;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\BeforeClass;

trait SqlTestEnable
{
    /**
     * @beforeClass
     */
    #[BeforeClass]
    final public static function beforeClassSqlTestEnable(): void
    {
        $resolver = new ConnectionResolver([
            'default' => new SQLiteConnection(new PDO('sqlite::memory:')),
        ]);
        $resolver->setDefaultConnection('default');
        Model::setConnectionResolver($resolver);
    }

    final protected static function assertQuerySql(
        string $expectedSql,
        array $expectedBindings,
        Builder $query,
    ): void {
        Assert::assertSame(trim($expectedSql), $query->toSql());
        Assert::assertSame($expectedBindings, $query->getBindings());
    }

    final protected function assertSql(callable $query, string $sql): void
    {
        try {
            ($query)();
            Assert::fail('Failed asserting that query was executed.');
        } catch (QueryException $queryException) {
            $expected = preg_replace('#\s+#', ' ', $sql);
            preg_match('#\(SQL: (?<sql>.*)\)$#', $queryException->getMessage(), $matches);

            Assert::assertSame($expected, $matches['sql']);
        }
    }
}
