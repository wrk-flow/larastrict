<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface HasCustomPrefixRoutes
{
    public function getRoutePrefix(string $generatedPrefix): string;
}
