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
    public const OneDecimalNonNull = self::class . ':1,true';
    public const ThreeDecimals = self::class . ':3';
    public const ThreeDecimalsNonNull = self::class . ':3,true';
    public const FourDecimals = self::class . ':4';
    public const FourDecimalsNonNull = self::class . ':4,true';
    public const NonNull = self::class . ':2,true';

    public function __construct(
        private readonly int $decimals = 2,
        private readonly bool $nonNull = false
    ) {
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null || $value === '') {
            return $this->nonNull ? 0.0 : null;
        }

        return (float) $value;
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        $floatVal = Value::toFloat((string) $value);

        if ($floatVal === null && $this->nonNull === false) {
            return null;
        }

        // Simulate value from database in DECIMAL format.
        return number_format($floatVal ?? 0.0, $this->decimals, '.', '');
    }
}
