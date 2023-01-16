<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use PHPUnit\Framework\Assert;

class TestListener implements TestListenerContract
{
    public function handle(TestEvent $event): void
    {
        Assert::fail('Listener should not be called');
    }
}
