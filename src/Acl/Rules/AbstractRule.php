<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Rules;

use LaraStrict\Acl\Contracts\AclCheckContract;

abstract class AbstractRule
{
    /**
     * Checks rule requirements (the resource must container required conditions).
     */
    abstract public function authorizerForRequirements(): ?AclCheckContract;

    /**
     * Creates authorizer that will check access rights.
     */
    abstract public function authorize(): AclCheckContract;
}
