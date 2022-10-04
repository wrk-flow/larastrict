<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

interface HasCustomServiceFileName
{
    public function getServiceFileName(): string;
}
