<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Illuminate\Database\Eloquent\Collection;
use LaraStrict\Database\Queries\AbstractEloquentQuery;
use LaraStrict\Database\Scopes\AbstractScope;
use Tests\LaraStrict\Feature\Database\Models\Test;

/**
 * This is not a real example of a query (scopes should not be a parameter in execute).
 *
 * @extends AbstractEloquentQuery<Test>
 */
class TestScopeQuery extends AbstractEloquentQuery
{
    /**
     * @param array<AbstractScope> $scopes
     * @return Collection<int, Test>
     */
    public function execute(array $scopes): Collection
    {
        return $this->getQuery($scopes)
            ->get();
    }

    protected function getModelClass(): string
    {
        return Test::class;
    }
}
