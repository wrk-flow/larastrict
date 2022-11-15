<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Contracts;

use Illuminate\Console\Command;
use LaraStrict\Testing\Entities\NamespaceEntity;

interface GetNamespaceForStubsActionContract
{
    public function execute(Command $command, string $basePath, string $inputClass): NamespaceEntity;
}
