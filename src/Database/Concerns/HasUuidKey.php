<?php

declare(strict_types=1);

namespace LaraStrict\Database\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $id
 */
trait HasUuidKey
{
    abstract public static function creating($closure);

    public function initializeHasUuidKey(): void
    {
        $this->incrementing = false;
        $this->setKeyType('string');
    }

    public static function bootHasUuidKey(): void
    {
        static::creating(static function (Model $model): void {
            /** @var HasUuidKey|Model $model */
            /** @phpstan-ignore-next-line */
            if ($model->id === null) {
                /** @phpstan-ignore-next-line */
                $model->id = (string) Str::uuid();
            }
        });
    }
}
