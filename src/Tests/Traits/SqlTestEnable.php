<?php

declare(strict_types=1);

namespace LaraStrict\Tests\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\SQLiteConnection;
use PDO;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\BeforeClass;

trait SqlTestEnable
{
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
}
