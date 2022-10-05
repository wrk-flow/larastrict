<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Actions;

use LaraStrict\Acl\Contracts\AclCheckContract;
use LaraStrict\Acl\Contracts\AclResultEntityContract;

class RunCheckAction
{
    public function execute(AclCheckContract $check): AclResultEntityContract
    {
        $result = $check();

        if ($result instanceof AclResultEntityContract) {
            return $result;
        }

        return $this->execute($check);
    }
}
