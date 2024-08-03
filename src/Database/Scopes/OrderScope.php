<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Enums\SortDirection;

class OrderScope extends AbstractScope
{
    public function __construct(
        private readonly string $column,
        private readonly SortDirection $direction = SortDirection::Asc,
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy($this->column, $this->direction->value);
    }
}
