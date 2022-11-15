<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use LaraStrict\Database\Scopes\WhereWithSoftDeletedScope;
use Tests\LaraStrict\Feature\Database\Queries\TestScopeQuery;
use Tests\LaraStrict\Feature\DatabaseTestCase;

class WhereWithSoftDeletedScopeTest extends DatabaseTestCase
{
    public function testApply(): void
    {
        /** @var TestScopeQuery $query */
        $query = $this->app()
            ->make(TestScopeQuery::class);

        $results = $query->execute([new WhereWithSoftDeletedScope()]);

        $this->assertCount(10, $results);

        $deletedAtNullCount = 0;
        $deletedAtNotNullCount = 0;
        foreach ($results as $result) {
            if ($result->deleted_at === null) {
                ++$deletedAtNullCount;
            } else {
                ++$deletedAtNotNullCount;
            }
        }

        $this->assertSame(5, $deletedAtNullCount);
        $this->assertSame(5, $deletedAtNotNullCount);
    }
}
