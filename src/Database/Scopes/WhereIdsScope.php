<?php

declare(strict_types=1);

namespace LaraStrict\Database\Scopes;

use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Deprecated;

class WhereIdsScope extends AbstractInScope
{
    /**
     * @param array<int>|array<string>|int|string $ids
     */
    public function __construct(
        array|int|string $ids,
        private readonly ?string $key = null,
        #[Deprecated(reason: 'Use right parameter instead of this magic.')]
        string|bool|null $booleanOrTableOrNot = null,
        string $table = '',
        bool $not = false,
    ) {
        parent::__construct($ids, $booleanOrTableOrNot, $table, $not);
    }

    protected function getColumn(Model $model): string
    {
        return $this->key ?? $model->getKeyName();
    }
}
