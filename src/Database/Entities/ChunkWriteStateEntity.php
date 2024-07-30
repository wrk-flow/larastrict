<?php

declare(strict_types=1);

namespace LaraStrict\Database\Entities;

use Illuminate\Database\Eloquent\Model;

class ChunkWriteStateEntity
{
    /**
     * @param class-string<Model>|null $modelClass
     * @param array<array<string, string|int|bool|float>> $toWrite
     */
    public function __construct(
        public int $batchSize = 0,
        public ?string $modelClass = null,
        public int $insertedCount = 0,
        public int $attributesCount = 0,
        public array $toWrite = [],
    ) {
    }
}
