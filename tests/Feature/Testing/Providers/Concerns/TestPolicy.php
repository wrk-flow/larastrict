<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Providers\Concerns;

class TestPolicy extends MyOtherPolicy
{
    public function one(): bool
    {
        return true;
    }
}
