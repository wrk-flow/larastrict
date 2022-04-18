<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Enums\SortDirections;

class OrderScope extends AbstractScope
{
    public function __construct(
        private readonly string $column,
        private readonly SortDirections $direction = SortDirections::ASC
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy($this->column, $this->direction->value);
    }
}
