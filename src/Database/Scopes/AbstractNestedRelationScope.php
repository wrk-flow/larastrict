<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class AbstractNestedRelationScope extends AbstractScope
{
    public function __construct(
        private readonly array $relationScopes = [],
        private readonly bool $useHas = false,
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $closure = function (QueryBuilder|Relation|Builder $query) use ($model): void {
            if ($query instanceof Relation) {
                $relationModel = $query->getRelated();
                $baseQuery = $query->getQuery();
            } else {
                $relationName = $this->getRelationName();

                if (method_exists($model, $relationName) === false) {
                    throw RelationNotFoundException::make($model, $relationName);
                }

                /** @var Relation<Model> $relation */
                $relation = $model->{$relationName}();
                $relationModel = $relation->getRelated();
                $baseQuery = $query;
            }

            foreach ($this->relationScopes as $relationScope) {
                $relationScope->apply($baseQuery, $relationModel);
            }
        };

        if ($this->useHas) {
            $builder->whereHas($this->getRelationName(), $closure);
        } else {
            $builder->with([
                $this->getRelationName() => $closure,
            ]);
        }
    }

    abstract protected function getRelationName(): string;
}
