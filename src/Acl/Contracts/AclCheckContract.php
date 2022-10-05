<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Contracts;

use LaraStrict\Acl\Entities\AclResultEntity;

interface AclCheckContract
{
    public function __invoke(): AclCheckContract|AclResultEntityContract;
}
