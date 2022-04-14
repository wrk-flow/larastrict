<?php

declare(strict_types=1);

namespace LaraStrict\Database\Queries;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Scope;

abstract class AbstractQuery
{
    /**
     * @param Scope[]|null[]|null $scopes
     */
    protected function getScopedQuery(Builder $query, ?array $scopes): Builder
    {
        if ($scopes === null) {
            return $query;
        }

        foreach ($scopes as $i => $scope) {
            if ($scope === null) {
                continue;
            }

            $query->withGlobalScope($i, $scope);
        }

        return $query;
    }
}
