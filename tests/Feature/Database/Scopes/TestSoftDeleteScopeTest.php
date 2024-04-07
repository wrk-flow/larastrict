<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use Tests\LaraStrict\Feature\Database\Models\TestModel;
use Tests\LaraStrict\Feature\Database\Queries\TestScopeQuery;
use Tests\LaraStrict\Feature\DatabaseTestCase;

class TestSoftDeleteScopeTest extends DatabaseTestCase
{
    public function testSoftDeletingGlobalScope(): void
    {
        /** @var TestScopeQuery $query */
        $query = $this->app()
            ->make(TestScopeQuery::class);

        $results = $query->execute([]);

        $this->assertCount(5, $results);

        foreach ($results as $result) {
            $this->assertInstanceOf(TestModel::class, $result);
            $this->assertNull($result->deleted_at);
        }
    }
}
