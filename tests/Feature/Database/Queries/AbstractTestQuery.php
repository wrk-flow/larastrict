<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use LaraStrict\Database\Queries\AbstractEloquentQuery;
use Tests\LaraStrict\Feature\Database\Models\TestModel;

/**
 * This is not a real example of a query (scopes should not be a parameter in execute).
 *
 * @extends AbstractEloquentQuery<TestModel>
 */
abstract class AbstractTestQuery extends AbstractEloquentQuery
{
    protected function getModelClass(): string
    {
        return TestModel::class;
    }
}
