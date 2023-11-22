<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class OrderByValuesScope extends AbstractScope
{
    private readonly string $direction;

    /**
     * @param array<string|int> $values
     */
    public function __construct(
        private readonly array $values,
        private readonly string $column,
        string $direction = 'ASC'
    ) {
        $this->direction = strtoupper((string) $direction);

        if ($this->direction !== 'ASC' && $this->direction !== 'DESC') {
            throw new InvalidArgumentException('Direction must be ASC or DESC');
        }
    }

    public function apply(Builder $builder, Model $model): void
    {
        $placeholders = array_map(static fn () => '?', $this->values);

        $builder->orderByRaw(
            'FIELD(`' . $this->column . '`, ' . implode(', ', $placeholders) . ') ' . $this->direction,
            $this->values
        );
    }
}
