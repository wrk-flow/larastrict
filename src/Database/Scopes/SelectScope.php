<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SelectScope extends AbstractScope
{
    /**
     * @param string[] $columns
     */
    public function __construct(
        private readonly array $columns,
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->select($this->columns);
    }
}
