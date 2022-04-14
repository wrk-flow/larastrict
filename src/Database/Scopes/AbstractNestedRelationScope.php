<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Scope;

abstract class AbstractNestedRelationScope implements Scope
{
    /**
     * @var array
     */
    private $relationScopes;

    public function __construct(array $relationScopes = [])
    {
        $this->relationScopes = $relationScopes;
    }

    abstract protected function getRelationNames(): array;

    public function apply(Builder $builder, Model $model): void
    {
        $relations = [];

        foreach ($this->getRelationNames() as $relationName) {
            $relations[$relationName] = function (Relation $relationQuery): void {
                foreach ($this->relationScopes as $relationScope) {
                    $relationScope->apply($relationQuery->getQuery(), $relationQuery->getModel());
                }
            };
        }

        $builder->with($relations);
    }
}
