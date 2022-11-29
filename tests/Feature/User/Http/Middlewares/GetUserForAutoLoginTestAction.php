<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\User\Http\Middlewares;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use LaraStrict\User\Contracts\GetUserForAutoLoginActionContract;
use PHPUnit\Framework\Assert;

class GetUserForAutoLoginTestAction implements GetUserForAutoLoginActionContract
{
    public function __construct(
        private readonly ?string $expectedAutoLogin,
    ) {
    }

    public function execute(string $autoLogin): ?Authenticatable
    {
        Assert::assertEquals($this->expectedAutoLogin, $autoLogin, 'Auto login value');
        return new User();
    }
}
