<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Acl\Rules;

use LaraStrict\Acl\Contracts\AclCheckContract;
use LaraStrict\Acl\Rules\AbstractRule;

class CanTest extends AbstractRule
{
    public function authorizerForRequirements(): ?AclCheckContract
    {
        return null;
    }

    public function authorize(): AclCheckContract
    {
        return new IsAllowed
    }
}
