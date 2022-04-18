<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrioritizeByIdScope extends AbstractScope
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        private readonly array $ids,
        private readonly string $idColumn
    ) {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $placeholders = array_map(fn () => '?', $this->ids);

        $builder->orderByRaw(
            'FIELD(' . $this->idColumn . ', ' . implode(', ', $placeholders) . ') DESC',
            $this->ids
        );
    }
}
