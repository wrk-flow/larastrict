<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Scope;

abstract class AbstractScope implements Scope
{
    protected function applyChildScope(Scope $scope, Builder $builder, Model $model): void
    {
        $scope->apply($builder, $model);
    }

    protected function applyRelationScope(Scope $scope, Relation $relation): void
    {
        $builder = $relation->getQuery();
        $scope->apply($builder, $builder->getModel());
    }

    public function applyOnRelation(Relation $relation): void
    {
        $this->applyRelationScope($this, $relation);
    }

    /**
     * Apply scope that contains with query and eager load relations to the model.
     */
    public function eagerLoadRelationsFromScope(Model $model): void
    {
        $query = $model->newQueryWithoutRelationships();
        $this->apply($query, $model);
        $query->eagerLoadRelations([$model]);
    }
}
