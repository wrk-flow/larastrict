<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Illuminate\Database\Eloquent\Scope;

class TestChunkSqlQuery extends AbstractTestQuery implements TestSqlQueryContract
{
    /**
     * @param array<int, Scope|null> $scopes
     */
    public function execute(array $scopes): string
    {
        return $this
            ->chunk($scopes)
            ->query
            ->toSql();
    }
}
