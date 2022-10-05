<?php

declare(strict_types=1);

namespace LaraStrict\Acl\Factories;


use Illuminate\Contracts\Auth\Guard;

class AclFactory
{
    public function __construct(
        public readonly Guard $guard,
    )
    {
    }

    public function hasUser(): bool
    {
        return $this->guard->hasUser();
    }
}
