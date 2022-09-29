<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Contracts;

interface GetBasePathForStubsActionContract
{
    public function execute(): string;
}
