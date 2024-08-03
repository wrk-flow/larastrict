<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $test
 * @property Carbon|null $deleted_at
 */
class TestNoDates extends Model
{
    /** @use HasFactory<TestModelFactory> */
    use HasFactory;

    use SoftDeletes;

    final public const CREATED_AT = null;
    final public const UPDATED_AT = null;
    final public const AttributeTest = 'test';
    final public const AttributeDeletedAt = 'deleted_at';

    protected $fillable = [self::AttributeTest];
}
