<?php

declare(strict_types=1);

namespace LaraStrict\Dimension\Entities;

class SizeEntity
{
    public function __construct(
        public float|int $width,
        public float|int $height,
    ) {
    }
}
