<?php

declare(strict_types=1);

namespace LaraStrict\Database\Models;

use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Concerns\HasTimestamps;
use LaraStrict\Database\Concerns\HasUuidKey;

abstract class UuidTimestampModel extends Model
{
    use HasUuidKey;
    use HasTimestamps;
    final public const ATTRIBUTE_ID = 'id';
}
