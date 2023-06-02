<?php

declare(strict_types=1);

namespace LaraStrict\Database\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use LaraStrict\Core\Helpers\Value;

/**
 * @implements CastsAttributes<float, null|int|string|float>
 */
final class FloatCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return (float) $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Value::toFloat((string) $value);
    }
}
