<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface HasPolicies
{
    /**
     * @return array<string, class-string>
     */
    public function policies(): array;
}
