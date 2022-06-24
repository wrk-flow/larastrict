<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface HasCustomServiceName
{
    public function getServiceName(): string;
}
