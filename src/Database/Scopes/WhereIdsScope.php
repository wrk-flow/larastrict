<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Model;

class WhereIdsScope extends AbstractInScope
{
    public function __construct(
        array $ids,
        private readonly ?string $key = null,
        string|bool|null $booleanOrTableOrNot = null,
        string $table = '',
        bool $not = false
    ) {
        parent::__construct($ids, $booleanOrTableOrNot, $table, $not);
    }

    protected function getColumn(Model $model): string
    {
        return $this->key ?? $model->getKeyName();
    }
}
