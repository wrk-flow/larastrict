<?php

declare(strict_types=1);

namespace Larastrict\Database\Models;

use Larastrict\Database\Concerns\HasTimestamps;
use Larastrict\Database\Concerns\HasUuidKey;
use Illuminate\Database\Eloquent\Model;

abstract class UuidTimestampModel extends Model
{
    use HasUuidKey;
    use HasTimestamps;

    public const ATTRIBUTE_ID = 'id';
}
