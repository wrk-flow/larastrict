<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Actions;

use LaraStrict\Acl\Contracts\AclResultEntityContract;
use LaraStrict\Acl\Rules\AbstractRule;

class AclAction
{

    public function __construct(
        private readonly RunCheckAction $runCheckAction,
    )
    {
    }

    public function execute(AbstractRule $rule): AclResultEntityContract
    {
        $check = $rule->authorize();

        return $this->runCheckAction->execute();
    }
}
