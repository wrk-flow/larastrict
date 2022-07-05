<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LaraStrict\Feature\Database\Queries\TestScopeQuery;
use Tests\LaraStrict\Feature\TestCase;

class TestSoftDeleteScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testSoftDeletingGlobalScope(): void
    {
        /** @var TestScopeQuery $query */
        $query = $this->app->make(TestScopeQuery::class);

        $results = $query->execute([]);

        $this->assertCount(5, $results);

        foreach ($results as $result) {
            $this->assertNull($result->deleted_at);
        }
    }
}
