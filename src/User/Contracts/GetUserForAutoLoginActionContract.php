<?php

declare(strict_types=1);

namespace LaraStrict\User\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface GetUserForAutoLoginActionContract
{
    public function execute(string $autoLogin): ?Authenticatable;
}
