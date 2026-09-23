<?php

declare(strict_types=1);

namespace LaraStrict\Database\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use LaraStrict\Core\Helpers\Value;

/**
 * @implements CastsAttributes<float, null|int|string|float>
 */
final readonly class FloatCast implements CastsAttributes
{
    // Laravel casts supports creating cast with arguments.
    public const string OneDecimal = self::class . ':1';
    public const string OneDecimalNonNull = self::class . ':1,true';
    public const string ThreeDecimals = self::class . ':3';
    public const string ThreeDecimalsNonNull = self::class . ':3,true';
    public const string FourDecimals = self::class . ':4';
    public const string FourDecimalsNonNull = self::class . ':4,true';
    public const string NonNull = self::class . ':2,true';

    public function __construct(
        private int $decimals = 2,
        private bool $nonNull = false,
    ) {
    }

    public function get($model, string $key, $value, array $attributes): ?float
    {
        // PDO can return native integers and floats for numeric columns.
        if ($value === null || $value === '' || is_numeric($value) === false) {
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
