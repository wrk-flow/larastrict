<?php

declare(strict_types=1);

namespace Tests\LaraStrict\App\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $test
 */
class Test extends Model
{
    use HasFactory;

    final public const ATTRIBUTE_TEST = 'test';

    protected $fillable = [self::ATTRIBUTE_TEST];
}
