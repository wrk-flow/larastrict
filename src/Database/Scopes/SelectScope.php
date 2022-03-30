<?php

declare(strict_types=1);

namespace Larastrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SelectScope implements Scope
{
    /**
     * @var string[]
     */
    private $columns;

    /**
     * @param string[] $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->select($this->columns);
    }
}
