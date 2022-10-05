<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Checks;

use LaraStrict\Acl\Contracts\AclCheckContract;
use LaraStrict\Acl\Contracts\AclResultEntityContract;

class IsOneOfCheck implements AclCheckContract
{
    public function __invoke(): AclCheckContract|AclResultEntityContract
    {
        // TODO: Implement __invoke() method.
    }
}
