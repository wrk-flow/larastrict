<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

abstract class AbstractQuery
{
    /**
     * @template TBuilderModel of \Illuminate\Database\Eloquent\Model
     * @param Builder<TBuilderModel>     $builder
     * @param array<int, Scope|null> $scopes
     *
     * @return Builder<TBuilderModel>
     */
    protected function getScopedQuery(Builder $builder, array $scopes): Builder
    {
        foreach ($scopes as $scope) {
            if ($scope === null) {
                continue;
            }

            // We are unable to reuse applyScope logic due protected methods (our scopes can contain withoutGlobalScope)
            $scope->apply($builder, $builder->getModel());
        }

        return $builder;
    }
}
