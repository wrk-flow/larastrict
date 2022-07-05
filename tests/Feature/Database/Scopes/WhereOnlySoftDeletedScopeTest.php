<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Scopes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaraStrict\Database\Scopes\WhereOnlySoftDeletedScope;
use Tests\LaraStrict\Feature\Database\Queries\TestScopeQuery;
use Tests\LaraStrict\Feature\TestCase;

class WhereOnlySoftDeletedScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testApplyExpectsOnlyDeletedEntriesFromInitDatabase(): void
    {
        /** @var TestScopeQuery $query */
        $query = $this->app->make(TestScopeQuery::class);

        $results = $query->execute([new WhereOnlySoftDeletedScope()]);

        $this->assertCount(5, $results);

        foreach ($results as $result) {
            $this->assertNotNull($result->deleted_at);
        }
    }
}
