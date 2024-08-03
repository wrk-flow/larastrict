<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraStrict\Database\Models\Casts\FloatCast;

/**
 * @property int $test
 * @property Carbon|null $deleted_at
 */
class TestModel extends Model
{
    /** @use HasFactory<TestModelFactory> */
    use HasFactory;

    use SoftDeletes;

    final public const AttributeTest = 'test';
    final public const AttributeDeletedAt = 'deleted_at';
    final public const AttributeFloatNonNull = 'float_non_null';
    final public const AttributeFloat = 'float';
    final public const AttributeFloat1Decimals = 'float_1_decimals';
    final public const AttributeFloat3Decimals = 'float_3_decimals';
    final public const AttributeFloat4Decimals = 'float_4_decimals';
    final public const AttributeFloat1DecimalsNonNull = 'float_1_decimals_non_null';
    final public const AttributeFloat3DecimalsNonNull = 'float_3_decimals_non_null';
    final public const AttributeFloat4DecimalsNonNull = 'float_4_decimals_non_null';

    protected $table = 'tests';
    protected $casts = [
        self::AttributeFloatNonNull => FloatCast::NonNull,
        self::AttributeFloat => FloatCast::class,
        self::AttributeFloat1Decimals => FloatCast::OneDecimal,
        self::AttributeFloat3Decimals => FloatCast::ThreeDecimals,
        self::AttributeFloat4Decimals => FloatCast::FourDecimals,
        self::AttributeFloat1DecimalsNonNull => FloatCast::OneDecimalNonNull,
        self::AttributeFloat3DecimalsNonNull => FloatCast::ThreeDecimalsNonNull,
        self::AttributeFloat4DecimalsNonNull => FloatCast::FourDecimalsNonNull,
    ];
    protected $fillable = [self::AttributeTest];
}
