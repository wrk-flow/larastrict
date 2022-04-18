<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class AbstractNestedRelationScope extends AbstractScope
{
    public function __construct(private readonly array $relationScopes = [])
    {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $relations = [];

        foreach ($this->getRelationNames() as $relationName) {
            $relations[$relationName] = function (Relation $relationQuery): void {
                $model = $relationQuery->getRelated();
                $baseQuery = $relationQuery->getQuery();

                foreach ($this->relationScopes as $relationScope) {
                    $relationScope->apply($baseQuery, $model);
                }
            };
        }

        $builder->with($relations);
    }

    abstract protected function getRelationNames(): array;
}
