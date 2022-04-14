<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use LaraStrict\Enums\SortDirections;

class OrderScope implements Scope
{
    private string $column;
    private SortDirections $direction;

    public function __construct(string $column, SortDirections $direction = SortDirections::ASC)
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy($this->column, $this->direction->value);
    }
}
