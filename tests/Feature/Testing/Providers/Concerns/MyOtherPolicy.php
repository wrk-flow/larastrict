<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Providers\Concerns;

class MyOtherPolicy implements MyOtherPolicyContract
{
    public function two(): bool
    {
        return true;
    }
}
