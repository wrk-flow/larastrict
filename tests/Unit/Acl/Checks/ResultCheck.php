<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Acl\Checks;

use LaraStrict\Acl\Contracts\AclCheckContract;
use LaraStrict\Acl\Contracts\AclResultEntityContract;

class ResultCheck implements AclCheckContract
{
    public function __invoke(): AclCheckContract|AclResultEntityContract
    {
        return
    }

}
