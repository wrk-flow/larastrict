<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Database\Services;

use Illuminate\Database\Eloquent\Model;

final class TestModel extends Model
{
    /**
     * @param array<array-key, mixed> $data
     */
    public static function insertOrIgnore(array $data): int
    {
        return count($data);
    }
}
