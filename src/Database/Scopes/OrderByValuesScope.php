<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderByValuesScope extends AbstractScope
{
    /**
     * @param array<string|int> $values
     */
    public function __construct(
        private readonly array $values,
        private readonly string $column
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $placeholders = array_map(static fn () => '?', $this->values);

        $builder->orderByRaw(
            'FIELD(`' . $this->column . '`, ' . implode(', ', $placeholders) . ') DESC',
            $this->values
        );
    }
}
