<?php

declare(strict_types=1);

namespace LaraStrict\Database\Models;

use LaraStrict\Database\Concerns\HasTimestamps;
use LaraStrict\Database\Concerns\HasUuidKey;
use Illuminate\Database\Eloquent\Model;

abstract class UuidTimestampModel extends Model
{
    use HasUuidKey;
    use HasTimestamps;

    public const ATTRIBUTE_ID = 'id';
}
