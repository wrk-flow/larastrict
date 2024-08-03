<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Illuminate\Database\Eloquent\Collection;
use LaraStrict\Database\Scopes\AbstractScope;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

/**
 * This is not a real example of a query (scopes should not be a parameter in execute).
 */
class TestScopeQuery extends AbstractTestQuery
{
    /**
     * @param array<AbstractScope> $scopes
     *
     * @return Collection<int, TestModel>
     */
    public function execute(array $scopes): Collection
    {
        return $this->getAll($scopes);
    }
}
