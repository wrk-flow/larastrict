<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GroupByScope extends AbstractScope
{
    /**
     * @param array<string> $groups
     */
    public function __construct(
        private readonly array $groups
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->groupBy($this->groups);
    }
}
