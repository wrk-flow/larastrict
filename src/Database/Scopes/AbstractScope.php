<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Scope;

abstract class AbstractScope implements Scope
{
    /**
     * @template TModel of Model
     * @param Builder<TModel> $builder
     */
    abstract public function apply(Builder $builder, Model $model): void;

    /**
     * @template TModel of Model
     * @param Relation<TModel> $relation
     */
    public function applyOnRelation(Relation $relation): void
    {
        $this->applyRelationScope($this, $relation);
    }

    /**
     * @template TModel of Model
     * @param Builder<TModel> $builder
     */
    public function applyOnBuilder(Builder $builder): void
    {
        $this->apply($builder, $builder->getModel());
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

    /**
     * @template TModel of Model
     * @param Builder<TModel> $builder
     */
    protected function applyChildScope(Scope $scope, Builder $builder, Model $model): void
    {
        $scope->apply($builder, $model);
    }

    /**
     * @template TModel of Model
     * @param Relation<TModel> $relation
     */
    protected function applyRelationScope(Scope $scope, Relation $relation): void
    {
        $builder = $relation->getQuery();
        $scope->apply($builder, $builder->getModel());
    }
}
