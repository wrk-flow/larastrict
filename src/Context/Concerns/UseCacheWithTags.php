<?php

declare(strict_types=1);

namespace LaraStrict\Context\Concerns;

interface UseCacheWithTags extends UseCache
{
    /**
     * @return array<string>
     */
    public function tags(): array;
}
