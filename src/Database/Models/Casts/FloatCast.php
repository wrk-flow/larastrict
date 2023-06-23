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
    // Laravel casts supports creating cast with arguments.
    public const OneDecimal = self::class . ':1';

    public const ThreeDecimals = self::class . ':3';

    public const FourDecimals = self::class . ':4';

    public function __construct(
        private readonly int $decimals = 2
    ) {
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value;
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        $floatVal = Value::toFloat((string) $value);

        if ($floatVal === null) {
            return null;
        }

        // Simulate value from database in DECIMAL format.
        return number_format($floatVal, $this->decimals, '.', '');
    }
}
