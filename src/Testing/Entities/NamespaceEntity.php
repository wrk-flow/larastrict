<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Entities;

class NamespaceEntity
{
    public function __construct(
        public readonly string $folder,
        public readonly string $baseNamespace,
    ) {
    }
}
