<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

final class GateForUserExpectation
{
    public function __construct(public readonly mixed $user)
    {
    }
}
